<div class="tab-pane" id="tasques">
    <div class="row">
        <div class="col-md-4">
            <div>
                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addTask"><i class="mdi mdi-plus mr-1"></i> Añadir tarea</button>
            </div>
        </div>
    </div>
    <?php
    $tasques = $database->select("tasques", [
        "id",
        "idProjecte",
        "idUser",
        "titol",
        "missatge",
        "prioritat",
        "active",
        "created_date"
        ],["AND"=>["idProjecte"=>$_GET['id'],"active"=>1],"ORDER"=>["created_date"=>"ASC"]
    ]);
    if(count($tasques)==0){echo '<div class="row"><div class="col-md-12 notTasks text-center">No hay tareas</div></div>';}
    foreach($tasques as $tasca){
        $estat = ["Sin prisa","Tener en cuenta","Manos a la obra", "Urgente"];
        $badge = ["secondary","info","warning","danger"];
    ?>
    <div class="taskItem shadow-none">
        <a href="#tascaCollapse<?php echo $tasca['id'];?>" class="collapsed text-body" data-toggle="collapse">
            <div class="taskTitle">
                <?php echo $tasca['titol'];?>
            </div>
        </a>

        <div id="tascaCollapse<?php echo $tasca['id'];?>" class="collapse">
            <div class="card-body taskBody">
                <div class="row">
                    <div class="taskTime">
                        <?php echo dateDistance($tasca['created_date']);?>
                    </div>

                    <div class="taskPriority text-right">
                        <div class="dropdown show">
                            <a class="text-body" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            </a>
                            <a class="text-body" href="" role="button" data-toggle="dropdown" aria-haspopup="true">
                                <span class="badge badge-pill badge-soft-<?php echo $badge[$tasca['prioritat']];?> font-size-12"><?php echo $estat[$tasca['prioritat']];?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=0&id=<?php echo $tasca['id'];?>">
                                    <span class="badge badge-pill badge-soft-secondary font-size-12"><?php echo $text['Sin prisa'];?></span>
                                </a>
                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=1&id=<?php echo $tasca['id'];?>">
                                    <span class="badge badge-pill badge-soft-info font-size-12"><?php echo $text['Tener en cuenta'];?></span>
                                </a>
                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=2&id=<?php echo $tasca['id'];?>">
                                    <span class="badge badge-pill badge-soft-warning font-size-12"><?php echo $text['Manos a la obra'];?></span>
                                </a>
                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=3&id=<?php echo $tasca['id'];?>">
                                    <span class="badge badge-pill badge-soft-danger font-size-12"><?php echo $text['Urgente'];?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="taskDescription">
                    <?php echo nl2br($tasca['missatge']);?>
                </div>
                <div class="row">
                    <div class="col-md-12 taskClose text-center">
                        <a href="conexiones/administracio.php?action=removeTask&id=<?php echo $tasca['id'];?>"><?php echo $text['Borrar tarea'];?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>