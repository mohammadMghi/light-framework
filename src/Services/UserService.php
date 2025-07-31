<?php 

namespace App\Services;

use App\Log\Interface\LoggerInterface;

class UserService
{
    protected LoggerInterface $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle()
    {
        $this->logger->log("test");
    }
}