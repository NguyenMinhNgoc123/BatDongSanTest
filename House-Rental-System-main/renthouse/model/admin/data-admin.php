<?php
class dataDB
{
    public static function getProducts()
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where note='0'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getProductsNote1()
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where note='1'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function editImg($property_id,$p_photo)
    {
        $db = Database::getDB();
        try {
            $query1 = "UPDATE property_photo SET p_photo='$p_photo' WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getImg($property_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from property_photo where property_id = :property_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function updateProducts($property_id,$chouse_id,$ptype_id,$caption,$kind_id,$city_id,$district_id,$ward_id,$street,$apartment_number,$estimated_price,$land_area,$description)
    {
        $db = Database::getDB();
        try {
            $query1 = "UPDATE add_property SET chouse_id='$chouse_id',ptype_id='$ptype_id',caption='$caption',kind_id='$kind_id',city_id='$city_id',district_id='$district_id',ward_id='$ward_id',street='$street',apartment_number='$apartment_number',estimated_price='$estimated_price',land_area='$land_area',description='$description' WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getdetails($property_id,$note)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where property_id =:property_id and note=:note";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->bindParam(':note', $note);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getListCheck($property_id,$note)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where property_id =:property_id and note=:note";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->bindParam(':note', $note);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function confirmProduct($property_id,$note,$update_note){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE add_property SET note='$note',update_note='$update_note' WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function deleteProduct($property_id,$note){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM add_property WHERE property_id='$property_id' and note='$note'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function DeletePayment($property_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM payment WHERE property_id=:property_id ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function deleteNotifyy($property_id,$type)
    {
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM notify WHERE property_id=:property_id and type=:type";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->bindParam(':type', $type);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function DeleteImage($property_id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM property_photo WHERE property_id=:property_id ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id',$property_id);
            $statement1->execute();
            $result1  = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function DeleteImageid($property_id,$limit){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM property_photo WHERE property_id=:property_id LIMIT {$limit}";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id',$property_id);
            $statement1->execute();
            $result1  = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getListUser()
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from tenant ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getListTenant($tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from tenant where tenant_id ='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function deleteTenant($tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM tenant WHERE tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getKindNews()
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from kind_news ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function updateKindNews($kind_id,$name,$price,$time){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE kind_news SET name='$name',price='$price',update_price='$time' WHERE kind_id='$kind_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function confirmPayment($property_id,$status,$start_date,$end_date,$start_status,$status_expires){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE payment SET status='$status',start_date='$start_date',end_date='$end_date',start_status='$start_status',status_expires='$status_expires' WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function selectPayment($property_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM payment WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getPayment()
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from payment";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getTimeExpires($create_time)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date1 = date('Y/m/d H:i:s');
        $date2 = $create_time;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

        //echo $years." năm, ".$months." tháng, ".$days." ngày ".$hours." giờ".$minutes." phút, ".$seconds." giây";
        if ((strtotime($date2) - strtotime($date1)) > 0){
            if ($days < 3){
                if ($days > 0 ){
                    $time = $days." ngày ".$hours." giờ ".$minutes." phút ".$seconds." giây";
                }else if ($hours > 0){
                    $time = $hours." giờ ".$minutes." phút ".$seconds." giây";
                }else if ($minutes > 0){
                    $time = $minutes." phút ".$seconds." giây";
                }else{
                    $time = $seconds." giây";
                }
            }  else{
                $time = 0;
            }
        } else{
            $time = 0;
        }
        return $time;
    }
    public static function getTimeExpiresPaid($end_date)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date1 = date('Y/m/d H:i:s');
        $date2 = $end_date;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

        //echo $years." năm, ".$months." tháng, ".$days." ngày ".$hours." giờ".$minutes." phút, ".$seconds." giây";
        if ((strtotime($date2) - strtotime($date1)) > 0) {
            if ($months == 0) {
                if ($days > 0) {
                    $time = $days . " ngày " . $hours . " giờ " . $minutes . " phút " . $seconds . " giây";
                } else if ($hours > 0) {
                    $time = $hours . " giờ " . $minutes . " phút " . $seconds . " giây";
                } else if ($minutes > 0) {
                    $time = $minutes . " phút " . $seconds . " giây";
                } else {
                    $time = $seconds . " giây";
                }
            } else {
                $time = 0;
            }
        }else {
            $time = 0;
        }
        return $time;
    }
    public static function updateExpiresProduct($property_id,$note){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE add_property SET note='$note' WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function updateExpires($property_id,$status,$start_date,$end_date,$start_status,$status_expires){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE payment SET status='$status',start_date='$start_date',end_date='$end_date',start_status='$start_status',status_expires='$status_expires' WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function insertNotify($tenant_id,$property_id,$comment,$type){
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO notify(tenant_id,property_id,comment,type) VALUES ('$tenant_id','$property_id','$comment','$type')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function updateNotify($tenant_id,$property_id,$comment,$type){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE notify SET comment='$comment' WHERE tenant_id ='$tenant_id' and property_id='$property_id' and type='$type'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function deleteNotifyNotType($property_id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM notify WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function deleteAccountPayment($tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM payment WHERE tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function deleteSession($tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM session_tenant WHERE tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function deleteAccountNotify($tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM notify WHERE tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getNotify()
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from notify";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getCheckTenant($tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where tenant_id =:tenant_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function deleteProductTenant($property_id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM add_property WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkPotential($tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from potential_customers where tenant_id =:tenant_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function updatePotential($tenant_id,$quantities)
    {
        $db = Database::getDB();
        try {
            $query1 = "update potential_customers set quantities =:quantities where tenant_id =:tenant_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->bindParam(':quantities', $quantities);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function insertPotential($tenant_id,$kind_id,$quantities){
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO potential_customers(tenant_id,kind_id,quantities) VALUES ('$tenant_id','$kind_id','$quantities')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getGrade()
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from grade ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function updateTenantGrade($tenant_id,$grade_id){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE tenant SET grade_id='$grade_id' WHERE tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function updateGrade($id,$name,$quantities,$discount,$update_at){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE grade SET name='$name',quantities='$quantities',discount='$discount',update_at='$update_at' WHERE grade_id='$id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function postEnquiry($property_id,$full_name,$email,$phone_no,$description,$create_at,$status){
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO post_enquiry (id,property_id,full_name,email,phone_no,description,status,create_at) values(null,'$property_id','$full_name','$email','$phone_no','$description','$status','$create_at')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function postEnquirycheck($property_id,$phone_no,$description){
        $db = Database::getDB();
        try {
            $query1 = "select * from post_enquiry where property_id='$property_id' and phone_no='$phone_no' and description='$description'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;

        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getPostEnquiry(){
        $db = Database::getDB();
        try {
            $query1 = "select * from post_enquiry where create_at < now()";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function EnquiryCheck($id){
        $db = Database::getDB();
        try {
            $query1 = "select * from post_enquiry where id ='$id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function updateEnquiry($id,$feedback,$status){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE post_enquiry SET feedback='$feedback',status='$status' WHERE id='$id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function DelelteEnquiry($id){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM post_enquiry WHERE id='$id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
}
