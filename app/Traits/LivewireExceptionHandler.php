<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\QueryException;

trait LivewireExceptionHandler
{
    /**
     * Handle exceptions and display appropriate error messages.
     * @param \Exception $e
     * @return void
     */
    public function handleException(Exception $e): void
    {
        if ($e instanceof QueryException) {
            $errorCode = $e->errorInfo[1] ?? null; // https://dev.mysql.com/doc/mysql-errors/8.0/en/server-error-reference.html

            switch ($errorCode){
                case 1048:
                    $column = $this->extractColumnFromMessage($e->getMessage());
                    $this->toast(
                        message: $column
                            ? __("errors.database.column_cannot_be_null", ['column' => $column])
                            : __("errors.database.missing_required_field"),
                        type: 'error'
                    );
                    break;

                default:
                    $this->toast(
                        message: __('errors.database.generic'),
                        type: 'error'
                    );
            }
            return;
        }

        $this->toast(
            message: __('errors.generic'),
            type: 'error'
        );
    }

    /**
     * Extract the column name from the error message.
     * @param string $message
     * @return string|null
     */
    protected function extractColumnFromMessage(string $message): ?string
    {
        if (preg_match("/Column '(.+?)' cannot be null/", $message, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
