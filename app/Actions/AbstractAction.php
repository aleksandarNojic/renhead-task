<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Database\ConnectionResolverInterface;

/**
 * Abstract Action.
 *
 */
abstract class AbstractAction
{
    /**
     * Request.
     *
     * @var Request
     */
    public $request;

    /**
     * Database connection manager.
     *
     * @var ConnectionResolverInterface
     */
    protected $dbm;

    /**
     * Service outcome status.
     *
     * @var bool
     */
    protected $status;

    /**
     * Determine whether to use a transaction for the
     * database queries in the handle method.
     *
     * @var bool
     */
    protected $transactional = true;

    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->request      = $request;
        $this->dbm          = app('db');
    }

    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    abstract public function handle(): bool;

    /**
     * Return the status.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * Run the service.
     *
     * @throws \Throwable
     * @return bool
     */
    public function run(): bool
    {
        if (method_exists($this, 'prepare')) {
            $this->prepare();
        }

        try {

            if (!$this->transactional) {
                $this->status = $this->handle();
            } else {
                $this->dbm->connection()->transaction(function () {
                    $this->status = $this->handle();
                });
            }
        } catch (\Throwable $exception) {

            if (method_exists($this, 'failed') && !config('app.debug')) {
                $this->failed($exception);
            }

            throw $exception;
        }

        if ($this->status && method_exists($this, 'success')) {
            $this->success();
        }

        return $this->status;
    }
}
