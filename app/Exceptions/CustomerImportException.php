<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Facades\Log;

class CustomerImportException extends Exception
{
    protected ?array $context;

    public function __construct(
        string $message = "Customer import failed.",
        int $code = 0,
        ?Throwable $previous = null,
        array $context = []
    ) {
        parent::__construct($message, $code, $previous);

        $this->context = $context;
        // we can still improve this, but for now this is ok
        Log::error($message, array_merge($context, [
            'exception' => $previous?->getMessage(),
            'trace' => $previous?->getTraceAsString(),
        ]));
    }

    public function context(): ?array
    {
        return $this->context;
    }
}
