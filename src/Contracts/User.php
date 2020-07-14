<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface User extends Request
{
    public function create(
        string $enterpriseUserSecretKey,
        string $fullname,
        string $username,
        string $email,
        string $password,
        string $phone,
        int $bank, // same id as in bank->all()
        string $accountNo,
        string $accountHolderName,
        ?string $registrationNo,
        ?int $package,
        ?int $userStatus
    ): Response;

    public function all(?string $partnerType): Response;

    public function status(string $username): Response;
}
