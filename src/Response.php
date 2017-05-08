<?php

namespace Rees\JsonRpc;

/**
 * Class Response
 *
 * @package \Rees\JsonRpc
 */
class Response
{
    /**
     * Protocol version.
     *
     * @var string
     */
    protected $version;

    /**
     * Method result.
     *
     * @var mixed
     */
    protected $result;

    /**
     * Method ID.
     *
     * @var string
     */
    protected $id;

    /**
     * Error code.
     *
     * @var int|null
     */
    protected $code;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message;

    /**
     * Error data.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Get Version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Set Version.
     *
     * @param string $version
     *
     * @return Response
     */
    public function setVersion(string $version): Response
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get Result.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set Result.
     *
     * @param mixed $result
     *
     * @return Response
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get Id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set Id.
     *
     * @param string $id
     *
     * @return Response
     */
    public function setId(string $id): Response
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get Code.
     *
     * @return int|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Code.
     *
     * @param int $code
     *
     * @return Response
     */
    public function setCode(int $code): Response
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set Message.
     *
     * @param string $message
     *
     * @return Response
     */
    public function setMessage(string $message): Response
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get Data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data.
     *
     * @param mixed $data
     *
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Is this response an error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return is_integer($this->code);
    }

    /**
     * Build array from response.
     *
     * @return array
     */
    public function toArray(): array
    {
        $payload = ['jsonrpc' => $this->version];

        if ($this->isError()) {
            $payload['error'] = [
                'code'    => $this->code,
                'message' => $this->message
            ];

            if (!is_null($this->data)) {
                $payload['error']['data'] = $this->data;
            }
        } else {
            $payload['result'] = $this->result;
        }

        $payload['id'] = $this->id;

        return $payload;
    }

    /**
     * Build JSON string from response.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Render the response as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
