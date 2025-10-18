<?php

include_once("class.paging.php");

class Logs extends mysqlConnection{

    public function insertLogs($logsData = array()){
        try {
            // Initialize MySQL connection
            $logsData['updated_on'] = date('Y-m-d H:i:s');
            $logsData['updated_by'] = $_SESSION['admin_id'];
            $mySqlConnection = new mysqlConnection();
            $db = $mySqlConnection->raw_handle();

            // Start transaction
            $db->beginTransaction();

            // Prepare SQL query with placeholders
            $sqlQuery = "INSERT INTO `logs` 
                (`page`, `reference_id`, `updated_by`, `updated_on`)
                VALUES 
                (:page, :reference_id, :updated_by, :updated_on)";

            $stmt = $db->prepare($sqlQuery);

            // Bind parameters
            $stmt->bindValue(':page', $logsData['page']);
            $stmt->bindValue(':reference_id', $logsData['reference_id']);
            $stmt->bindValue(':updated_by', $logsData['updated_by']);
            $stmt->bindValue(':updated_on', $logsData['updated_on']);

            // Execute query
            $result = $stmt->execute();

            // Commit transaction
            $db->commit();
            return true;

        } catch (PDOException $e) {
            // Rollback if something fails
            $db->rollBack();
            echo "Error: " . $e->getMessage();die;
            return false;
        }

    }

    public function getLastUpdatedLogs($data) {
        try {
           
            $returnData = [];

            // Initialize DB connection
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();

            // Start transaction (optional for read-only)
            $DBH->beginTransaction();

            // Prepare SQL query with named placeholders
            $sql = "SELECT lg.updated_on as updatedOn, ta.username as updatedBy, lg.updated_by as updatedById
                FROM `logs` lg
                INNER JOIN `tbladmin` ta ON ta.admin_id = lg.updated_by
                WHERE lg.reference_id = :reference_id
                AND lg.page = :page
                ORDER BY lg.id DESC
            LIMIT 1;";
            $STH = $DBH->prepare($sql);
            // Execute query with proper values
            $STH->execute([
                ':reference_id' => $data['reference_id'],
                ':page' => $data['page']
            ]);

            // Fetch result if exists
            if ($STH->rowCount() > 0) {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
               
                $returnData = [
                    'updateById' => $row['updatedById'],
                    'updateBy' => $row['updatedBy'],
                    'updateOn' => date('d M Y H:i', strtotime($row['updatedOn'])), // use timestamp column
                ];
            }

            // Commit transaction (optional if read-only)
            $DBH->commit();
           
            return $returnData;

        } catch (PDOException $e) {
            $DBH->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getUsersOption($data){
        try {

            // Initialize DB connection
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();

            // Start transaction (optional for read-only)
            $DBH->beginTransaction();

            // Prepare SQL query with named placeholders
            $sql = "SELECT DISTINCT(ta.admin_id) as admin_id, ta.username as username
                FROM `logs` lg
                INNER JOIN `tbladmin` ta ON ta.admin_id = lg.updated_by
                WHERE lg.page = :page  ";
            $STH = $DBH->prepare($sql);
            // Execute query with proper values
            $STH->execute([
                ':page' => $data['type']
            ]);

            // Fetch result if exists
            if ($STH->rowCount() > 0) {
                return  $STH->fetchAll(PDO::FETCH_ASSOC);
            }

            // Commit transaction (optional if read-only)
            $DBH->commit();
           
            return [];

        } catch (PDOException $e) {
            $DBH->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getLogsDetails($data){
        try {
           
            // Initialize DB connection
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();

            // Start transaction (optional for read-only)
            $DBH->beginTransaction();

            $customSearch = '';
            if (!empty($data['start_date'])) {
                $customSearch .= " AND DATE_FORMAT(lg.updated_on, '%Y-%m-%d') >= '" . $data['start_date'] . "'";
            }

            if (!empty($data['end_date'])) {
                $customSearch .= " AND DATE_FORMAT(lg.updated_on, '%Y-%m-%d') <= '" . $data['end_date'] . "'";
            }

            if ((int) $data['user']>0) {
                $customSearch .= " AND lg.updated_by = '" . $data['user'] . "'";
            }

            // Prepare SQL query with named placeholders
            $sql = "SELECT lg.page as page, lg.updated_on as updated_on, ta.username as username
                FROM `logs` lg
                INNER JOIN `tbladmin` ta ON ta.admin_id = lg.updated_by
                WHERE lg.page = :page $customSearch AND lg.reference_id=:reference_id ORDER BY id DESC";
            $STH = $DBH->prepare($sql);
            
            // Execute query with proper values
            $STH->execute([
                ':page' => $data['type'],
                ':reference_id' => $data['id']
            ]);

            // Fetch result if exists
            if ($STH->rowCount() > 0) {
                return $STH->fetchAll(PDO::FETCH_ASSOC);
            }

            // Commit transaction (optional if read-only)
            $DBH->commit();
           
            return [];

        } catch (PDOException $e) {
            $DBH->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getFirstUpdatedLogs($data) {
        try {
           
            $returnData = [];

            // Initialize DB connection
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();

            // Start transaction (optional for read-only)
            $DBH->beginTransaction();

            // Prepare SQL query with named placeholders
            $sql = "SELECT lg.updated_on as updatedOn, ta.username as updatedBy, lg.updated_by as updatedById
                FROM `logs` lg
                INNER JOIN `tbladmin` ta ON ta.admin_id = lg.updated_by
                WHERE lg.reference_id = :reference_id
                AND lg.page = :page
                ORDER BY lg.id ASC
            LIMIT 1;";
            $STH = $DBH->prepare($sql);
            // Execute query with proper values
            $STH->execute([
                ':reference_id' => $data['reference_id'],
                ':page' => $data['page']
            ]);

            // Fetch result if exists
            if ($STH->rowCount() > 0) {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
               
                $returnData = [
                    'updateById' => $row['updatedById'],
                    'updateBy' => $row['updatedBy'],
                    'updateOn' => date('d M Y H:i', strtotime($row['updatedOn'])), // use timestamp column
                ];
            }

            // Commit transaction (optional if read-only)
            $DBH->commit();
           
            return $returnData;

        } catch (PDOException $e) {
            $DBH->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


	
}

?>