<?php

namespace App\Services;

use Google_Client;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Illuminate\Support\Facades\Cache;

class GoogleWorkspaceService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/google/service-account.json')); // ✅ pakai file JSON kamu
        $this->client->addScope('https://www.googleapis.com/auth/admin.directory.user');
        $this->client->setSubject('it@smktelkom-lpg.sch.id'); // ✅ Email super admin

        $this->service = new Google_Service_Directory($this->client);
    }

    public function resetPassword($email, $newPassword)
    {
        try {
            $user = new Google_Service_Directory_User([
                'password' => $newPassword
            ]);

            $this->service->users->update($email, $user);
            return true;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function listUsers($maxPerPage = 500)
    {
        return Cache::remember('google_users_cache', now()->addMinutes(10), function () use ($maxPerPage) {
            $allUsers = [];
            $pageToken = null;

            do {
                $params = [
                    'customer' => 'my_customer',
                    'maxResults' => $maxPerPage,
                    'orderBy' => 'email',
                    'pageToken' => $pageToken
                ];

                $result = $this->service->users->listUsers($params);
                // $allUsers = array_merge($allUsers, $result->getUsers());
                foreach ($result->getUsers() as $user) {
                    $allUsers[] = [
                        'email' => $user->getPrimaryEmail(),
                        'name' => $user->getName()->getFullName(),
                        'last_login' => $user->getLastLoginTime(),
                        'suspended' => $user->getSuspended(),
                        'id' => $user->getId(),
                        'is_admin' => $user->getIsAdmin(),
                    ];
                }
                $pageToken = $result->getNextPageToken();
            } while ($pageToken);

            return $allUsers;
        });
    }

    public function getUser($userId)
    {
        $user = $this->service->users->get($userId);

        return [
            'id' => $user->getId(),
            'email' => $user->getPrimaryEmail(),
            'name' => $user->getName()->getFullName(),
            'given_name' => $user->getName()->getGivenName(),
            'family_name' => $user->getName()->getFamilyName(),
            'is_admin' => $user->getIsAdmin(),
            'suspended' => $user->getSuspended(),
            'last_login' => $user->getLastLoginTime(),
            'photo_url' => $user->getThumbnailPhotoUrl(),
        ];
    }

    public function resetPasswordById($userId, $plainPassword)
    {
        $hashedPassword = sha1($plainPassword); // ⬅️ Ini yang wajib

        $user = new \Google_Service_Directory_User([
            'password' => $hashedPassword,
            'hashFunction' => 'SHA-1',
        ]);

        return $this->service->users->update($userId, $user);
    }
}
