<?php 

    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "db_data";

    try {
        $db = new PDO("mysql:host={$db_host}; dbname={$db_name}", $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }
    if (isset($_REQUEST['btn_insert'])) {
        $f_firstname = $_REQUEST['f_firstname'];
        $id_order = $_REQUEST['id_order'];
        $a_activities = $_REQUEST['a_activities'];
        $ttype_id = $_POST ['ttype_id'];


        if (empty($f_firstname)) {
            $errorMsg = "กรอกชื่อ";
        } else if (empty($id_order)) {
            $errorMsg = "กรอกid";
        } else if (empty($a_activities)) {
            $errorMsg = "a_activities";

        } 
         else if (empty($ttype_id)) {
            $errorMsg = "ttype_id";

        }else {
            try {
                if (!isset($errorMsg)) {
                    $insert_stmt = $db->prepare("INSERT INTO m_activities (f_firstname, id_order, a_activities,ttype_id) VALUES (:f_firstname, :id_order,:a_activities,:ttype_id)");
                    $insert_stmt->bindParam(':f_firstname', $f_firstname);
                    $insert_stmt->bindParam(':id_order', $id_order);
                    $insert_stmt->bindParam(':a_activities', $a_activities);
                    $insert_stmt->bindParam(':ttype_id', $ttype_id);

                    if ($insert_stmt->execute()) {
                        
                        header("location:page.php");
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>



