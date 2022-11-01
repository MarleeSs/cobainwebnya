<?php

namespace Login\Management\PHP\Repository;

use Login\Management\PHP\Domain\User;
use PDOStatement;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): User
    {
        $timeStamp = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));

        $statement = $this->connection
            ->prepare("INSERT INTO users(email, username, password, created_at) VALUES (?, ?, ?, ?)");

        $statement->execute([
            $user->email, $user->username, $user->password, $timeStamp->format('Y-m-d H:i:s')
        ]);
        return $user;
    }

    public function updateEmail(User $user): User
    {
        $timeStamp = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));

        $statement = $this->connection->prepare("UPDATE users SET email = ?, email_updated_at = ? WHERE username = ?");
        $statement->execute([
            $user->email, $timeStamp->format('Y-m-d H:i:s'), $user->username
        ]);
        return $user;
    }

    public function updatePassword(User $user): User
    {
        $timeStamp = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));

        $statement = $this->connection->prepare("UPDATE users SET password = ?, password_updated_at = ? WHERE username = ?");
        $statement->execute([
            $user->password, $timeStamp->format('Y-m-d H:i:s'), $user->username
        ]);
        return $user;
    }


    public function findByUsername(string $username): ?User
    {
        $statement = $this->connection->prepare("SELECT email, username, password, created_at, email_updated_at, password_updated_at FROM users WHERE username = ?");
        return $this->extracted($statement, $username);
    }

    /**
     * @param bool|PDOStatement $statement
     * @param string $username
     * @return User|null
     */
    public function extracted(bool|PDOStatement $statement, string $username): ?User
    {
        $statement->execute([$username]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->email = $row['email'];
                $user->username = $row['username'];
                $user->password = $row['password'];
                $user->created_at = $row['created_at'];
                $user->email_updated_at = $row['email_updated_at'];
                $user->password_updated_at = $row['password_updated_at'];
                return $user;
            } else {
                return null;
            }

        } finally {
            $statement->closeCursor();
        }
    }

    public function findByEmail(string $email): ?User
    {
        $statement = $this->connection->prepare("SELECT email, username, password, created_at, email_updated_at, password_updated_at FROM users WHERE email = ?");
        return $this->extracted($statement, $email);
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE from users");
    }
}