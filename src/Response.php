<?php

namespace AimanDaniel\ToyyibPay;

use Laravie\Codex\Exceptions\NotFoundException;
use Laravie\Codex\Exceptions\UnauthorizedException;
use Laravie\Codex\Response as BaseResponse;

class Response extends BaseResponse
{
    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return trim(parent::getBody());
    }

    /**
     * Validate the response object.
     *
     * @return $this
     */
    public function validate()
    {
        parent::validate();

        $this->abortIfInvalidCategoryCode();

        return $this;
    }

    /**
     * Check if response is unauthorized.
     *
     * @return bool
     */
    public function isUnauthorized(): bool
    {
        $body = trim($this->getBody());

        $unauthorizedFlag = (false !== strpos("[KEY-DID-NOT-EXIST-OR-USER-IS-NOT-ACTIVE]", $body));

        return parent::isUnauthorized() || $unauthorizedFlag;
    }

    /**
     * Validate for unauthorized request.
     *
     * @throws \Laravie\Codex\Exceptions\UnauthorizedException
     *
     * @return void
     */
    public function abortIfRequestUnauthorized(): void
    {
        if ($this->isUnauthorized()) {
            throw new UnauthorizedException($this, 'Invalid secret key');
        }
    }

    /**
     * Check if the category code is invalid
     *
     * @return boolean
     */
    public function isInvalidCategoryCode(): bool
    {
        return strpos("[CATEGORY-NOT-MATCH]", trim($this->getBody())) !== false;
    }

    /**
     * Validate for invalid category code request.
     *
     * @throws \Laravie\Codex\Exceptions\NotFoundException
     *
     * @return void
     */
    public function abortIfInvalidCategoryCode(): void
    {
        if ($this->isInvalidCategoryCode()) {
            throw new NotFoundException($this, 'Invalid category code');
        }
    }
}