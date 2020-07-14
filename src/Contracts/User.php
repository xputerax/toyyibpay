<?php

namespace AimanDaniel\ToyyibPay\Contracts;

use Laravie\Codex\Contracts\Request;
use Laravie\Codex\Contracts\Response;

interface User extends Request
{
    const STATUS_INACTIVE = '0';
    const STATUS_PENDING = '1';
    const STATUS_ACTIVE = '2';

    const PARTNER_OEM = 'OEM';
    const PARTNER_ENTERPRISE = 'ENTERPRISE';

    public function create(
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
