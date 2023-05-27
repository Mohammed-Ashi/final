<?php
class DbHelper{

    private $conn;
    function createDbConnection(){
try{
    $this->conn = new mysqli("localhost","root","","final");
}catch (Exception $error){
    echo $error->getMessage();

}
    }
    function insertNewEmployee($name,$salary,$image){
        try{
            $file_link = $this->saveImage($image);
            $sql = "INSERT INTO employee (employee_name,employee_salary,employee_image)VALUES ('$name','$salary','$file_link')";
            $result =  $this->conn->query($sql);
            if($result==true){
                $this->createResponse(true,1,
                    $this->createEmployeeResponse($this->conn->insert_id,
                    $name,
                    $salary,
                    $file_link,
                        )
                    );
                }else{
                $this->createResponse(false,0,"data has not been inserted");
  
            }
  
        }catch (Exception $error){
            $this->createResponse(false,0,$error->getMessage());
  
  
        }
      }
      function getAllEmployee(){
       try{
           $sql = "select * from employee";
           $result = $this->conn->query($sql);
  
           $numOfEmp =  $result->num_rows;
           if($numOfEmp >0){
               $all_employee_array = array();
               while ($row = $result->fetch_assoc()){
                   $id = $row["employee_id"];
                   $name = $row["employee_name"];
                   $salary = $row["employee_salary"];
                   $image = $row["employee_image"];
                   $employee_array = $this->createEmployeeResponse($id,$name,$salary,$image);
                   array_push($all_employee_array,$employee_array);
               }
               $this->createResponse(true,$numOfEmp,$all_employee_array);
           }
           else{
            throw new Exception("No Data Found");
        }
       }catch (Exception $exception){
           $this->createResponse(false,0,array("error"=>$exception->getMessage()));
       }
  
  
      }
     
      function getEmployeeById($id){
          $sql = "select * from employee where employee_id = $id";
          $result = $this->conn->query($sql);
          try{
              if($result->num_rows ==0){
                  throw new Exception("no employee with the id=$id");
              }
              else{
                  $row = $result->fetch_assoc();
                  $id = $row["employee_id"];
                  $name = $row["employee_name"];
                  $salary = $row["employee_salary"];
                  $image = $row["employee_image"];

                  $employee_array = $this->createEmployeeResponse($id,$name,$salary,$image);
                  $this->createResponse(true,1,$employee_array);
  
              }
          }
          catch (Exception $exception){
              http_response_code(400);
              $this->createResponse(false,0,array("error"=>$exception->getMessage()));
          }
  
      }
      function deleteEmployee($id) {
        try {
            $sql = "DELETE FROM employee WHERE employee_id = $id";
            $result = $this->conn->query($sql);
    
            if (mysqli_affected_rows($this->conn) > 0) {
                $this->createResponse(true, 1, array("data" => "Employee has been deleted"));
            } else {
                throw new Exception("No employee with id=$id");
            }
        } catch (Exception $exception) {
            $this->createResponse(false, 0, array("error" => $exception->getMessage()));
        }
    }
    
    
    
    function updateEmployee($id, $name, $salary, $image) {
        try {
            $file_link = $this->saveImage($image);
            $sql = "UPDATE employee SET employee_name='$name', employee_salary='$salary', employee_image='$file_link' WHERE employee_id=$id";
            $result = $this->conn->query($sql);
    
            if ($result == true) {
                $this->createResponse(true, 1, $this->createEmployeeResponse(
                    $id,
                    $name,
                    $salary,
                    $file_link
                ));
            } else {
                $this->createResponse(false, 0, "No employee found with id=$id");
            }
        } catch (Exception $exception) {
            $this->createResponse(false, 0, array("error" => $exception->getMessage()));
        }
    }
    


  function saveImage($file){
      $dir_name = "images/";
      $fullPath = $dir_name.$file["name"];
      move_uploaded_file($file["tmp_name"],$fullPath);
      $file_link = "http://localhost/db_example/$fullPath";
      return $file_link;
  }
  
  function createResponse($isSuccess,$count,$data){
          echo json_encode(array(
              "success"=>$isSuccess,
              "count"=>$count,
              "data"=>$data
          ));
  }
  function createEmployeeResponse($id,$name,$salary,$image_url){
          return array(
              "id"=>$id,
              "name"=>$name,
              "salary"=>$salary,
              "image"=>$image_url,
          );
  }
  }
  ?>