<?php
include 'includes/session.php';

if(isset($_GET['id'])){
    $jid = $_GET['id'];
    
    $conn = $pdo->open();

    try{
        $stmt = $conn->prepare("DELETE FROM jobs WHERE jid=:jid");
        $stmt->execute(['jid'=>$jid]);

        $_SESSION['success'] = 'Job deleted successfully';
    }
    catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }

    $pdo->close();
}
else{
    $_SESSION['error'] = 'Select job to delete first';
}

header('location: jobs.php');

?>