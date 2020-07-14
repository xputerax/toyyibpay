<?php

namespace AimanDaniel\ToyyibPay\Base;

use AimanDaniel\ToyyibPay\Contracts\User as Contract;
use Laravie\Codex\Concerns\Request\Multipart;
use Laravie\Codex\Contracts\Response;
use Laravie\Codex\Request;

abstract class User extends Request implements Contract
{
    use Multipart;

    public function create(
        string $fullname,
        string $username,
        string $email,
        string $password,
        string $phone,
        int $bank, // same id as in getbank()
        string $accountNo,
        string $accountHolderName,
        ?string $registrationNo, // WIP: handle param
        ?int $package, // WIP: handle package & userStatus param
        ?int $userStatus
    ): Response {
        return $this->stream('POST', 'createAccount', [], [
            'enterpriseUserSecretKey' => $this->client->getApiKey(),
            'fullname' => $fullname,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
            'bank' => $bank,
            'accountNo' => $accountNo,
            'accountHolderName' => $accountHolderName,
            'registrationNo' => $registrationNo,
            'package' => $package,
        ]);
    }

    // WIP: handle $partnertype
    public function all(?string $partnerType): Response
    {
        $this->client->useAdminApiEndpoint();

        return $this->stream('POST', 'getAllUser', [], [
            'userSecretKey' => $this->client->getApiKey(),
            'partnerType' => $partnerType ?? 'OEM',
        ]);
    }

    public function status(string $username): Response
    {
        return $this->client->uses('User.Status')->get($username);
    }
}
