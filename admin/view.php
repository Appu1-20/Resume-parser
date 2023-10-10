<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    View
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">View</li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <div>
                                    <?php
                                        $conn = $pdo->open();
                                        $id = $_GET['id'];
                                        $stmt = $conn->prepare("SELECT * FROM resume WHERE id=$id"); 
                                        $stmt->execute();
                                        // $detail=$stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <table class="table table-bordered" id="resumeList">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>File Name</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Address</th>
                                                <th>Skills</th>
                                                <th>Language</th>
                                                <th>Experience</th>
                                                <th>Education</th>
                                                <th>Projects</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($stmt as $resume) {
                                                ?><tr><?php
                                                ?><td><?php echo $i;
                                                $i++;
                                                ?></td><?php
                                                ?><td><a href="../users/<?php echo $resume['filename'] ?>"
                                                        target="_blank"><?php echo $resume['filename'];
                                                ?></a></td><?php
                                                ?><td>
                                                    <a href="view.php?id=<?php echo $resume['id'] ?>">
                                                        <?php echo $resume['Name'];
                                                ?>
                                                    </a>

                                                </td><?php
                                                ?><td><?php echo $resume['Contact'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Address'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Skills'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Language'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Experience'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Education'];
                                                ?></td><?php 
                                                ?><td>
                                                    <?php echo $resume['Projects'];
                                                ?></tr><?php 
                                            }
                                        ?>
                                        </tbody>
                                    </table>


                                    <div>
                                        <h3>You may Like</h3>
                                    </div>
                                    <?php
                                         $stmt = $conn->prepare("SELECT * FROM resume WHERE id=$id"); 
                                         $stmt->execute();
                                         $detail = $stmt->fetch(PDO::FETCH_ASSOC);
                                      
                                         function jaccard_similarity($set1, $set2) {
                                            $intersection = count(array_intersect($set1, $set2));
                                            $union = count(array_unique(array_merge($set1, $set2)));
                                            
                                            if ($union === 0) {
                                                return 0; // Avoid division by zero
                                            }
                                            
                                            return $intersection / $union;
                                        }
                                    
                                        $currentSkills = [];

                                        if (strpos($detail['Skills'], ',') !== false) {
                                            $currentSkills = explode(',', $detail['Skills']);
                                        } else {
                                            $currentSkills[] = $detail['Skills'];
                                        }
                                        $conns = $pdo->open();
                                        $stmt_res = $conns->prepare("SELECT * FROM resume"); 
                                        $stmt_res->execute();
                                        $all_resumes = $stmt_res->fetchAll(PDO::FETCH_ASSOC);


                                        $results = [];


                                        foreach ($all_resumes as $resume) {
                                            if($resume['id'] !=$id){
                                                $resumeSkills = [];
                                                if (strpos($resume['Skills'], ',') !== false) {
                                                    $resumeSkills = explode(',', $resume['Skills']);
                                                } else {
                                                    $resumeSkills = [$resume['Skills']];
                                                }
                                                $resumeSkills = explode(',', $resume['Skills']);
                                                $similarity = jaccard_similarity($currentSkills, $resumeSkills);

                                                $results[] = [
                                                    'resume' => $resume,
                                                    'similarity' => $similarity,
                                                ];
                                            }
                                        }

                                        usort($results, function ($a, $b) {
                                            return $b['similarity'] <=> $a['similarity'];
                                        });

                                        $filteredRecommendations = [];

                                        foreach ($results as $result) {
                                            if ($result['similarity'] > 0) {
                                                $filteredRecommendations[] = $result['resume'];
                                            }
                                        }

                                        $topRecommendations = array_slice($filteredRecommendations, 0, 4);


                                    ?>
                                    <table class="table table-bordered" id="resumeList">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>File Name</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Address</th>
                                                <th>Skills</th>
                                                <th>Language</th>
                                                <th>Experience</th>
                                                <th>Education</th>
                                                <th>Projects</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($topRecommendations as $resume) {
                                                ?><tr><?php
                                                ?><td><?php echo $i;
                                                $i++;
                                                ?></td><?php
                                                ?><td><a href="../users/<?php echo $resume['filename'] ?>"
                                                        target="_blank"><?php echo $resume['filename'];
                                                ?></a></td><?php
                                                ?><td>
                                                    <a href="view.php?id=<?php echo $resume['id'] ?>">
                                                        <?php echo $resume['Name'];
                                                ?>
                                                    </a>

                                                </td><?php
                                                ?><td><?php echo $resume['Contact'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Address'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Skills'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Language'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Experience'];
                                                ?></td><?php
                                                ?><td><?php echo $resume['Education'];
                                                ?></td><?php 
                                                ?><td>
                                                    <?php echo $resume['Projects'];
                                                ?></tr><?php 
                                            }
                                        ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

            </section>
        </div>