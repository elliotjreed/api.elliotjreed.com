<?php

declare(strict_types=1);

namespace App\Response;

final class ApiResponseData
{
    private mixed $data = null;
    private array $errorMessages = [];
    private ?string $redirectUrl = null;

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function setErrorMessages(string ...$errorMessages): self
    {
        $this->errorMessages = $errorMessages;

        return $this;
    }

    public function addErrorMessage(string ...$errors): self
    {
        $this->errorMessages = [...$this->errorMessages, ...$errors];

        return $this;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    public function setRedirectUrl(?string $redirectUrl): self
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'data' => $this->getData(),
            'errors' => $this->getErrorMessages(),
            'redirectUrl' => $this->getRedirectUrl()
        ];
    }
}
