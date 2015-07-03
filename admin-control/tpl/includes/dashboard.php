<?php //forceRedirect('?module=Commit'); ?>
<div class="headline">Dashboard </div>
            
            
            
            <?php $ObjnewsType= new NewsType();$menudata=$ObjnewsType->get(array('backend'=>'1'));//var_dump($menudata); ?>
                <?php foreach($menudata as $row):?>
                        <div class="gallery_box1 ">
                            <?php if($row[$ObjnewsType->getPrefix().'url'] !=1): ?>
                                <a href="home.php?module=<?php echo $row[$ObjnewsType->getPrefix().'url']; ?>">
                                    <img src="../uploads/newstype/thumb/<?php if(isset($row['news01file']) && ($row['news01file'] !='')) echo $row['news01file']; else echo 'noicon.png' ;?>"></a>
                                <div class="cleaner"></div>
                                <a href="home.php?module=<?php echo $row[$ObjnewsType->getPrefix().'url']; ?>"><?php echo $row['news01title'];?></a>
                                
                            
                            <?php elseif($row['news01hasChild']): ?>
                                
                                <a href="home.php?module=News&Type=<?php echo $row['news01uin'];?>">
                                    <img src="../uploads/newstype/thumb/<?php if(isset($row['news01file']) && ($row['news01file'] !='')) echo $row['news01file']; else echo 'noicon.png' ;?>"></a>
                                <div class="cleaner"></div>
                                <a href="home.php?module=News&Type=<?php echo $row['news01uin'];?>"><?php echo $row['news01title'];?></a>
                                
                            <?php else: ?>
                                <a href="home.php?module=NewsType&action=edit&_Id=<?php echo $row['news01uin'];?>">
                                    <img src="../uploads/newstype/thumb/<?php if(isset($row['news01file']) && ($row['news01file'] !='')) echo $row['news01file']; else echo 'noicon.png' ;?>"></a>
                                <div class="cleaner"></div>
                                <a href="home.php?module=NewsType&action=edit&_Id=<?php echo $row['news01uin'];?>"><?php echo $row['news01title'];?></a>
                                
                            <?php endif; ?>
                            
                            </div>
                <?php endforeach; ?>
            

            
            
            
            