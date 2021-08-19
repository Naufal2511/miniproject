<?php
    session_start() ;
    if(isset($_SESSION['uid'])) {
        require_once 'includes/dbh.inc.php' ;
        require_once 'includes/functions.inc.php' ;
        $GLOBALS['conn'] = $conn ;

        $uid = $_SESSION['uid'] ;
        $GLOBALS['uid'] = $uid ;
        
        $project_title = $_POST['project_title'] ;
        $GLOBALS['project_title'] = $_POST['project_title'] ;

        $project_desc = $_POST['project_desc'] ;
        $GLOBALS['project_desc'] = $project_desc ;

        $project_date = date('y.m.d') ; //gets the date of execution

        $flag = 0 ;

        if(isset($_POST['usubbutton'])) {
            $file = $_FILES['project_img'] ;
            $fileName = $file['name'] ;
            $fileTmpName = $file['tmp_name'] ;
            $fileSize = $file['size'] ;
            $fileError = $file['error'] ;
            $fileType = $file['type'] ;

            $fileExt = explode('.',$fileName);
            $fileExt = strtolower(end($fileExt)) ;

            $allowed = array('jpg','jpeg', 'png', 'gif', 'tiff') ;

            if(in_array($fileExt, $allowed))    {
                if($fileError === 0)    {
                    if($fileSize < 5000000) {
                        $flag = 1 ;
                        $pid = findpid($flag,$conn,$project_title,$project_desc,$fileExt,$project_date) ;
                        if($pid == -1)  {
                            echo "went wrong !!!" ;
                        }
                        else    {
                        $fileNameNew = $uid."_".$pid.".".$fileExt ; 
                        echo $fileNameNew . "success in uploading to uploads";
                        $fileDest = 'uploads/'.$fileNameNew ;
                        move_uploaded_file($fileTmpName,$fileDest) ;
                        header("Location: welcome.php?error=none") ;
                        }
                    }
                    else    {
                        header("location: upload.php?error=toobig") ;
                        // echo "Error : Your file is too big !!!" ;
                        exit() ;
                    }
                }
                else    {
                    echo "Something went wrong" ;
                }
            }
            else    {
                header("location: upload.php?error=wrongfiletype") ;
                exit() ;
                // echo "wrong file type. Only jpg/jpeg/png/gif/tiff files are allowed" ;
            }
        // }

        
            // function findpid($flag, $fileExt)  {
            //     $uid = $GLOBALS['uid'] ;
            //     $project_desc = $GLOBALS['project_desc'] ;
            //     $project_title = $GLOBALS['project_title'] ;
            //     $conn = $GLOBALS['conn'] ;

            //     if($flag == 1)  {
                    
            //         echo "uid : ".$uid." ".$project_desc." ".$project_title."<br>" ;
            
            //         $sql1 = "INSERT INTO projectdetails (uid,project_title, project_desc, project_ext) VALUES ('$uid','$project_title','$project_desc','$fileExt')" ;
            //         if(mysqli_query($conn,$sql1))    {
            //             echo "<script>alert('successfully stored in database');</script>" ;
            //         } 
            //         else{
            //             echo "errors : ".mysqli_error($conn) ;
            //         }
            
            //         // $sq8 = "SELECT pid FROM projectdetails WHERE uid = '$uid'" ;
            //         $sql2 = "SELECT pid FROM projectdetails WHERE pid=(SELECT MAX(pid) FROM projectdetails)" ;

            //         // $sq5 = "SELECT uid, username, email, password FROM userdetails WHERE email = '$email'" ;
            //         $query1 = mysqli_query($conn, $sql2) ;
            //         if($query1)  {
            //             while($row = mysqli_fetch_assoc($res6))    {
            //                 print_r($row) ;
            //                 $pid = $row['pid'] ;
            //                 echo "success" ;
            //             }
            //             return $pid ;
            //         }
            //         else{
            //             echo " erors in selecting data" ;
            //         }
            //     }
            //     else{
            //         echo "critical error, failed to upload" ;
            //         return -1 ;
            //     }
            // }
        }
    }
    else    {
        header("Location: login.php?error=loginrequired") ;
        exit() ;
    }
?>

