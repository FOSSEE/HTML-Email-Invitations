<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
  require_once('connection.inc');
  if (isset($_GET) && isset($_GET['key']))
    {
      $email_id_hash = $_GET['key'];
      $event         = $_GET['event'];
      unsubscribeEmailid($email_id_hash, $event);
    }
  else
    {
      echo 'wrong link';
    }
  function unsubscribeEmailid($email_id_hash, $event)
    {
      global $conn;
      // try to update user with specified information
      $email_id_hash = urldecode($email_id_hash);
     // var_dump($email_id_hash);die;
      $sql           = "SELECT email, unsubscribe, email_hash  FROM sent_email WHERE email_hash = :email_id_hash AND event= :event";
      $q             = $conn->prepare($sql);
      $q->execute(array(
          'email_id_hash' => $email_id_hash,
          'event' => $event
      ));
      while ($data = $q->fetchAll(PDO::FETCH_ASSOC))
        {
          foreach ($data as $row)
            {
              if ($data != NULL)
                {
                  switch ($event)
                  {

                     case 'scipy 2015':
                          if ($row['unsubscribe'] == 0 && $row['email_hash'] == $email_id_hash)
                            {
                              $sql_up = "UPDATE sent_email SET unsubscribe = 1 WHERE email_hash =:email_id_hash ";
                              $q_up   = $conn->prepare($sql_up);
                              $q_up->execute(array(
                                  ':email_id_hash' => $email_id_hash
                              ));
                              echo '<br>Thank You for unsubscription';
                              echo '<br><br>If you are not automatically redirected, click here: <a href="http://scipy.in">SciPy India 2015</a>.';
                              header('Refresh: 3; URL=http://scipy.in');
                            }
                          elseif ($row['unsubscribe'] == 1 && $row['email_hash'] == $email_id_hash)
                            {
                              echo '<br>You are already unsubscribed!';
                              echo '<br><br>If you are not automatically redirected, click here: <a href="http://scipy.in">SciPy India 2015</a>.';
                              header('Refresh: 3; URL=http://scipy.in');
                            }
                          else
                            {
                              echo '<br>You are not a subscriber!';
                              echo '<br><br>If you are not automatically redirected, click here: <a href="http://scipy.in">SciPy India 2015</a>.';
                              header('Refresh: 3; URL=http://scipy.in');
                            }
                          break;
                      case 'cfd-openfoam-symposium 2016':
                          if ($row['unsubscribe'] == 0 && $row['email_hash'] == $email_id_hash)
                            {
                              $sql_up = "UPDATE sent_email SET unsubscribe = 1 WHERE email_hash =:email_id_hash";
                              $q_up   = $conn->prepare($sql_up);
                              $q_up->execute(array(
                                  ':email_id_hash' => $email_id_hash
                              ));
                              echo '<br>Thank You for unsubscription';
                              echo '<br><br>If you are not automatically redirected, click here: <a href="http://fossee.in/conference/cfd-symposium/">OpenFOAM Symposium 2016</a>.';
                              header('Refresh: 3; URL=http://fossee.in/conference/cfd-symposium/');
                            }
                          elseif ($row['unsubscribe'] == 1 && $row['email_hash'] == $email_id_hash)
                            {
                              echo '<br>You are already unsubscribed!';
                              echo '<br><br>If you are not automatically redirected, click here: <a href="http://fossee.in/conference/cfd-symposium/">OpenFOAM Symposium 2016</a>.';
                              header('Refresh: 3; URL=http://fossee.in/conference/cfd-symposium/');
                            }
                          else
                            {
                              echo '<br>You are not a subscriber!';
                              echo '<br><br>If you are not automatically redirected, click here: <a href="http://scipy.in">OpenFOAM Symposium 2016</a>.';
                              header('Refresh: 3; URL=http://fossee.in/conference/cfd-symposium/');
                            }
                          break;
                  }
                }
              else
                {
                  echo "Wrong Link please try again";
                  header('Refresh: 3; URL=http://fossee.in');
                }
            }
        }
    }
  $conn = null;
?>
