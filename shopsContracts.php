<?php

include_once "page/header.php";
if(!isset($_SESSION['preLogin']))
return;
?>


<div id="shopContracts" class="row col-sm-12">

<div id="page-title"><span>العقود</span></div><br>

    <div id="section" class="col-12 col-md-7 col-lg-5">
        
        <?php
        
        $sql = "SELECT * FROM contracts WHERE type='shop'";
        $query = mysqli_query($connect, $sql);
        
        ?>
        
        <ul>
        
            <?php
            
            while($row = mysqli_fetch_array($query)){
                
                $id = $row['id'];
                $name = $row['name'];
                $word_file_name = $row['word_file_name'];
                $pdf_file_name = $row['pdf_file_name'];
                
                ?>
            <li>
                <p><? echo $name ?></p>
                <div class="operations">
                    <a href="files/shopsContracts/word_files/<? echo $word_file_name; ?>"><span class="btn btn-primary col-5 col-md-4">تحميل العقد بصيغة word</span></a>
                    <a href="files/shopsContracts/pdf_files/<? echo $pdf_file_name; ?>"><span class="btn btn-primary col-5 col-md-4">تحميل العقد بصيغة pdf</span></a>
                    <a href="shopsContracts.php?delete=<? echo $id; ?>"><span class="btn btn-danger col-12 col-md-12">حذف</span></a>
                </div>
            </li>
            
            <?php
                
            }
            
            ?>
            
        </ul>
        
    </div>
    

</div>


<script>

    $(document).ready(function(){
        
        
        $("#addContractFormBTN").click(function(){
                
                
                $("#addContractForm").slideToggle(500);
                
            });
        
        
        $("#uplaodWord").click(function(){
            $("input[name='wordFile']").click();
        })
        
        $("#uploadPdf").click(function(){
            $("input[name='pdfFile']").click();
        })
        
        
    })

    

</script>

<form class="from-group col-10 col-md-4" id="addContractForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <input type="text" name="contractName" placeholder="اسم العقد" class="form-control" />
    <input type="file" name="wordFile" class="form-control" style="display: none;" />
    <input type="file" name="pdfFile" class="form-control" style="display: none;" />
    <span id="uplaodWord" class="btn btn-primary" >رفع ملف الوورد <i class="fas fa-upload"></i></span>
    <span id="uploadPdf" class="btn btn-primary" >رفع ملف pdf <i class="fas fa-upload"></i></span>
    <input type="submit" name="addContractBTN" value="إضافة" class="btn btn-primary" />
</form>


        <a id="addContractFormBTN"><i id="addNewContractBTN" class="fas fa-plus-circle"></i></a>



<?php


if(isset($_POST['addContractBTN'])){
    
    
    $contractName = $_POST['contractName'];
    
    $wordName = $_FILES['wordFile']['name'];
    $wordTmp = $_FILES['wordFile']['tmp_name'];
    
    $pdfName = $_FILES['pdfFile']['name'];
    $pdfTmp = $_FILES['pdfFile']['tmp_name'];
    
    
//    if($word_name != "" && $pdf_name != ""){
//        
//        
//        
//    }
    
    
    $sql = "INSERT INTO contracts (name, word_file_name, pdf_file_name, type) VALUES ('$contractName','$wordName','$pdfName','shop')";
    
    $query = mysqli_query($connect, $sql);
    
    if($query){
        
        if(isset($_FILES['wordFile'])){
        move_uploaded_file($wordTmp, "files/shopsContracts/word_files/".iconv('utf-8','windows-1256',$wordName));
        }
        
        if(isset($_FILES['pdfFile'])){
        move_uploaded_file($pdfTmp, "files/shopsContracts/pdf_files/".iconv('utf-8','windows-1256',$pdfName));
        }
        
        
        ?>
<meta http-equiv="refresh" content="0;url=shopsContracts.php" >
<?php
        
    }else{
        
        echo "There is problem in inserting the files";
    }
    
    
}


if(isset($_GET['delete'])){
    
    
    $contract_id = $_GET['delete'];
    
    $sql = "DELETE FROM contracts WHERE id='$contract_id'";
    $query = mysqli_query($connect, $sql);
    
    if($query){
        
        ?>
<meta http-equiv="refresh" content="0;url=shopsContracts.php" />
<?php
        
    }else{
        echo "Error: can't delete the contract number $contract_id";
    }
    
}


include_once "page/footer.php";

?>

