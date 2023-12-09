<?php

class ContactManager
{
    private $db; // Propriété pour stocker l'objet PDO

    public function __construct()
    {
        $db_host = "localhost";
        $db_user_name = "root";
        $db_password = "";
        $db_name = "test";

        $pdo = "mysql:host=$db_host;dbname=$db_name";

        try {

            $this->db = new PDO($pdo, $db_user_name, $db_password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
    }

    public function addContact($nom, $prenom, $numero, $email)
    {
        if (isset($nom, $prenom, $numero, $email)) {
            try {
                $sql = "INSERT INTO contact (nom, prenom, numero_telephone, email) VALUES (?, ?, ?, ?)";
                $query = $this->db->prepare($sql);
                $result = $query->execute([$nom, $prenom, $numero, $email]);

                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo "Erreur PDO : " . $e->getMessage();
                return false;
            }
        }

        return false;
    }


    public function filterContact($name, $prenom)
    {
        if (!empty($prenom)) {
            $sql = "SELECT * FROM contact WHERE prenom LIKE ?";
            $query = $this->db->prepare($sql);
            $query->execute(["%$prenom%"]);
            $contacts = $query->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            return $contacts;
        }

        if (!empty($name)) {
            $sql = "SELECT * FROM contact WHERE nom LIKE ?";
            $query = $this->db->prepare($sql);
            $query->execute(["%$name%"]);
            $contacts = $query->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            return $contacts;
        }
    }




    public function getContacts()
    {
        $sql = "SELECT * FROM contact";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contacts = $query->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        return $contacts;
    }

    public function deleteContact($id)
    {
        $sql = "DELETE FROM contact WHERE id = ?";
        $query = $this->db->prepare($sql);
        $result = $query->execute([$id]);
        return $result;
    }

    public function EditContact($id, $name, $username, $telephone, $email)
    {
        $sql = "update contact set nom = ?, prenom = ?, numero_telephone = ?, email = ? where id = ?";
        $query = $this->db->prepare($sql);
        $result = $query->execute([$name, $username, $telephone, $email, $id]);
        return $result;
    }
}
