<?php

require_once('connection.inc');
header('Refresh: 3; URL=http://scipy.in');
if(isset($_GET) && isset($_GET['key'])){

	 unsubscribeEmailid($_GET['key']);

}else{

echo 'wrong link';
}

function unsubscribeEmailid($email_id_hash)
    {
    global $conn;

   // try to update user with specified information

                 $sql = "SELECT email, unsubscribe, email_hash  FROM sent_email WHERE email_hash = :email_id_hash ";
                 $q = $conn->prepare($sql);
                 $q->execute(array('email_id_hash'=>$email_id_hash));


  while($data = $q->fetchAll(PDO::FETCH_ASSOC)) {
        foreach($data as $row){


            if($data != NULL){

                      if($row['unsubscribe'] == 0 && $row['email_hash'] == $email_id_hash){

			       $sql_up = "UPDATE sent_email SET unsubscribe = 1 WHERE email_hash =:email_id_hash ";
                               $q_up = $conn->prepare($sql_up);
                               $q_up->execute(array(':email_id_hash'=>$email_id_hash));

                             echo '<br>Thank You for unsubscription';
                             echo '<br><br>If you are not automatically redirected, click here: <a href="http://scipy.in">SciPy India 2015</a>.';
                     }

            elseif($row['unsubscribe'] == 1 && $row['email_hash'] == $email_id_hash){
                             echo '<br>You are already unsubscribed!';
                             echo '<br><br>If you are not automatically redirected, click here: <a href="http://scipy.in">SciPy India 2015</a>.';
            }

            else{
                             echo '<br>You are not a subscriber!';
                             echo '<br><br>If you are not automatically redirected, click here: <a href="http://scipy.in">SciPy India 2015</a>.';
              }

         }else{

              echo "Wrong Link please try again";  
      }
    }
  }
}

$conn=null;
?>
