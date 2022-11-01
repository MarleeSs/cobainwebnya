<?php

namespace Login\Management\PHP\Repository;

use Login\Management\PHP\Domain\Session;

class SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        $statement = $this->connection->prepare("INSERT INTO sessions(id, username) VALUES (?, ?)");
        $statement->execute([$session->id, $session->userUsername]);
        return $session;
    }

    public function findByUsername(string $username): ?Session
    {
        $statement = $this->connection->prepare("SELECT id, username FROM sessions WHERE id = ?");
        $statement->execute([$username]);

        try {
            if ($row = $statement->fetch()) {
                $session = new Session();
                $session->id = $row['id'];
                $session->userUsername = $row['username'];
                return $session;
            } else {
                return null;
            }
        } finally {
            {
                $statement->closeCursor();
            }
        }
    }

    public function deleteByUsername($username): void
    {
        $statement = $this->connection->prepare("DELETE FROM sessions WHERE id = ?");
        $statement->execute([$username]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM sessions");
    }
}