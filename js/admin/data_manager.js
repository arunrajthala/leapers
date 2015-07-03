
    var giCount = 0;
    //var innerArray = [];
    var cacheArray = [];
    var outerArray=[];
    var TotDebit=0;
    var TotCredit = 0;
    var DispArr=[];
    var ColArray=[];
    var DivID='example';
    
    function test(id)
    {
        var x=id.split("|");
        var a =confirm("Are You Sure ???");
		if(! a )
		{
            return false;
		}
        else
        {
            window.location= './home.php?module='+x[0]+'&delete=1&_Id='+x[1];
        }
    }
    function delData(id,redURL)
    {
        var x=id.split("|");
        var a =confirm("Are You Sure ???");
		if(! a )
		{
            return false;
		}
        else
        {
            window.location= './home.php?module='+x[0]+'&delete=1&_Id='+x[1]+redURL;
        }
    }
    function resetPass(id)
    {
        //var x=id.split("|");
        var a =confirm("Are You Sure ???");
		if(! a )
		{
            return false;
		}
        else
        {
            window.location= './home.php?module=resetPass&_Id='+id;
        }
    }

     function MakeCashedArray(inputArray) { 
        giCount=1;
             DispArr=[];
             cacheArray=[];
             //alert(inputArray);
             for (i=0;i<inputArray.length;i++)
             {
                 var y =[];
                 var id=0;
                 for(j=0;j<5; j++)
                 {
                     if(j==0)
                        y.push(giCount);
                     else 
                        y.push(inputArray[i][j]);
                     if(j==1)
                         id=inputArray[i][j];
                    // i++;
                 }
                 giCount++;
                 //i--;
                 //alert(inputArray[i]);
                 
                 y.push("<input  type ='button' onclick='removeRow(this.id)' value='Delete' class='btn' id ='" + id + "'>");
                 cacheArray.push(y);
             }
             myJsonString=JSON.stringify(inputArray);
             // refresh hidden textboxes 
             $('#hidDiv').html('');
             var $hiddenInput = $('<input/>', { type: 'hidden', id: 'hidarray', name: 'hidArray', value: myJsonString });
        $hiddenInput.appendTo('#hidDiv');
        /*
         var $hiddenInput = $('<input/>', { type: 'text', id: 'hidunpostdata', name: 'hidUnpostdata', value: innerArray });
                 $hiddenInput.appendTo('#hidDiv');
         */
        var $hiddenInput = $('<input/>', { type: 'hidden', id: '_hidunpost', name: '_hidUnpost', value: inputArray });
        $hiddenInput.appendTo('#hidDiv');
             //return _cacheArray;
         }
     
    
    function removeRow(code)
    {
        //alert(code);
        for(var i = 0; i < outerArray.length; i++) 
        {
            //alert(outerArray[i]);
            if (outerArray[i][1] == code) 
            {
            outerArray.splice(i, 1);
            MakeCashedArray(outerArray);
            RefreshList();
            break;
            }
        }
    }
    function RefreshList()
    {
        //Name of Std.	Exam Details	Subject	Score	High Score	Full Score
        //Rank	Name of Std.	Score	FullScore	Percent
        $('#dynamic').html( '<table class="responsive table table-striped table-bordered" id="example"></table>' );
				$('#example').dataTable( 
                {
					"aaData": cacheArray,
                    "sPaginationType": "full_numbers",
                    
					"aoColumns": [
                        { "sTitle": "Sn." },
						{ "sTitle": "" },
						{ "sTitle": "" },
						{ "sTitle": "" },
						{ "sTitle": "High Score", "sClass": "center" },
						{ "sTitle": "Full Score", "sClass": "center" },
                        { "sTitle": "Action", "sClass": "center" }
					           ]
				} );
                //alert(cacheArray);
       
    }
    function convertToDetail(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['std_name']);
            x.push(mainArray[i]['exam']);
            x.push(mainArray[i]['subject']);
            x.push(mainArray[i]['score']);
            x.push(mainArray[i]['max_score']);
            x.push(mainArray[i]['full_score']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "Student Name" },{ "sTitle": "Exam Details" },
                    { "sTitle": "Subject Detail     " },{ "sTitle": "OM" },{ "sTitle": "HM" },{ "sTitle": "FM" }];
        return finalArray;
   }
   function convertToBrief(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['std_name']);
            x.push(mainArray[i]['score']);
            x.push(mainArray[i]['total']);
            x.push(mainArray[i]['percent']);
            
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "Student Name" },
                    { "sTitle": "OM" },{ "sTitle": "FM" },{ "sTitle": "Percent" }];
        return finalArray;
   }
   function Report(inputArray,DivId)
   {
        //Name of Std.	Exam Details	Subject	Score	High Score	Full Score
        $('#'+DivId).html( '<table class="responsive table table-striped table-bordered" id="'+ '_'+DivId +'"></table>' );
				$('#_'+DivId).dataTable( {
					"aaData": inputArray,
                    "sPaginationType": "full_numbers",
					"aoColumns": ColArray
				} );
   }
   function StudentwiseReport(mainArray)
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['exam']);
            x.push(mainArray[i]['subject']);
            x.push(mainArray[i]['examscore']);
            x.push(mainArray[i]['max_score']);
            x.push(mainArray[i]['full_score']);
            x.push(mainArray[i]['attempt']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "Exam Title","sClass": "center" },{ "sTitle": "Subject Name" },
                    { "sTitle": "OM" },{ "sTitle": "HM" },{ "sTitle": "FM" },{ "sTitle": "atmp" }];
        return finalArray;
   }
   function SubjectwiseReport(mainArray)
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            
            x.push(mainArray[i]['std_name']);
            x.push(mainArray[i]['examscore']);
            x.push(mainArray[i]['max_score']);
            x.push(mainArray[i]['full_score']);
            x.push(mainArray[i]['attempt']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "Name of Student" },
                    { "sTitle": "OM" },{ "sTitle": "HM" },{ "sTitle": "FM" },{ "sTitle": "atmp" }];
        return finalArray;
   }
   function convertToStudent(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['exam']);
            x.push(mainArray[i]['subject']);
            x.push(mainArray[i]['examscore']);
            x.push(mainArray[i]['max_score']);
            x.push(mainArray[i]['full_score']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Exam Title","sClass": "center" },{ "sTitle": "Subject Name" },
                    { "sTitle": "OM" },{ "sTitle": "HM" },{ "sTitle": "FM" }];
        return finalArray;
   }
   
   function StudentReport(inputArray)
   {
        //Name of Std.	Exam Details	Subject	Score	High Score	Full Score
        $('#dynamic').html( '<table class="responsive table table-striped table-bordered" id="example"></table>' );
				$('#example').dataTable({
					"sPaginationType": "full_numbers",
                    "aaData": inputArray,
					"aoColumns": [
                        { "sTitle": "Sn", "sClass": "center" },
						{ "sTitle": "Exam" },
						{ "sTitle": "Subject        " },
						{ "sTitle": "OM", "sClass": "center" },
						{ "sTitle": "HM", "sClass": "center" },
                        { "sTitle": "FM", "sClass": "center" }
					],
				} );
   }
   function convertToBatch(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['std_name']);
            x.push(mainArray[i]['score']);
            x.push(mainArray[i]['total']);
            x.push(mainArray[i]['percent']);
            //x.push(mainArray[i]['full_score']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Rank","sClass": "center" },{ "sTitle": "Student Name" },
                    { "sTitle": "Score" },{ "sTitle": "Total" },{ "sTitle": "Percent" }];
        return finalArray;
   }
   function BatchReport(inputArray)
   {
        //Name of Std.	Exam Details	Subject	Score	High Score	Full Score
        $('#dynamic').html( '<table class="responsive table table-striped table-bordered" id="example"></table>' );
				$('#example').dataTable( {
					"aaData": inputArray,
                    "sPaginationType": "full_numbers",
					"aoColumns": [
                        { "sTitle": "Rank" },
						{ "sTitle": "Name of Std." },
                        { "sTitle": "Full Score", "sClass": "center" },
                        { "sTitle": "Total Score", "sClass": "center" },
                        { "sTitle": "Percentage", "sClass": "center"  },
					]
				} );
   }
    function ConvertArray(inputArray)
    {
        if (inputArray ==null)
            return;
        for (i=0;i<inputArray.length;i++)
             {
                 var y =[];
                 var id=0;
                 
                     y.push(giCount+1);
                    //item 1 uin item2=ledger, item 3 =dr item 4= cr item 5 = unpostuin 6= narration)
                    y.push(inputArray[i]["Ledger"]["UIN"]);
                    y.push(inputArray[i]["DebitAmt"]);
                    y.push(inputArray[i]["CreditAmt"]);
                    y.push(inputArray[i]["Particulars"]);
                    y.push(inputArray[i]["UIN"]);
                    y.push(inputArray[i]["UnPost"]["UIN"]);
                    // i++;
                 giCount++;
                 //i--;
                 //alert(inputArray[i]);
                 
                 //y.push("<input  type ='button' onclick='removeRow(this.id)' value='Delete' class='btn' id ='" + id + "'>");
                 outerArray.push(y);
             }
    }
    function makeStdList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['std_id']);
            x.push(mainArray[i]['std_name']);
            x.push(mainArray[i]['user']);
            x.push(mainArray[i]['phone']);
            x.push(mainArray[i]['cl_id']);
            x.push('<a href="home.php?module=liststudent&action=edit&_Id='+mainArray[i]['std_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="liststudent|'+mainArray[i]['std_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Student Name" },
                    { "sTitle": "User Name" },{ "sTitle": "Phone" },{ "sTitle": "Batch" },{"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makeStdRep(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['std_id']);
            x.push(mainArray[i]['std_name']);
            x.push(mainArray[i]['user']);
            x.push(mainArray[i]['phone']);
            x.push(mainArray[i]['cl_id']);
            x.push('<a href="home.php?module=student&action=view&_Id='+mainArray[i]['std_id']+'"><img src="../img/view.png" height="16px" width="16"></a> ');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Student Name" },
                    { "sTitle": "User Name" },{ "sTitle": "Phone" },{ "sTitle": "Batch" },{"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makeExamList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['ex_id']);
            x.push(mainArray[i]['details']);
            x.push(mainArray[i]['year']);
            //alert('<a href="home.php?module=listexam&action=edit&_Id='+mainArray[i]['ex_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="'+mainArray[i]['ex_id']+'" href="'+window.location);
            x.push('<a href="home.php?module=listexam&action=edit&_Id='+mainArray[i]['ex_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listexam|'+mainArray[i]['ex_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            //alert(mainArray[i]['year']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Examination Title" },
                    { "sTitle": "Year" },{"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makeExamRep(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['ex_id']);
            x.push(mainArray[i]['details']);
            x.push(mainArray[i]['year']);
            x.push('<a href="home.php?module=exam&action=view&_Id='+mainArray[i]['ex_id']+'"><img src="../img/view.png" height="16px" width="16"></a> ');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Examination Title" },
                    { "sTitle": "Year" },{"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makesubjectList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['sub_id']);
            x.push(mainArray[i]['details']);
            
            x.push('<a href="home.php?module=listsubject&action=edit&_Id='+mainArray[i]['sub_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listsubject|'+mainArray[i]['sub_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Subject Title" },
                  {"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makeAlbumList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['im_id']);
            x.push(mainArray[i]['details']);
            x.push('<img src="../image/'+ mainArray[i]['img'] +'" height ="64px" width="64px">');
            x.push('<a href="home.php?module=listalbum&action=edit&_Id='+mainArray[i]['im_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listalbum|'+mainArray[i]['im_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Album Title" },{ "sTitle": "Image", "sClass": "center" },
                  {"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makePhotoList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['im_id']);
            x.push(mainArray[i]['details']);
            x.push('<img src="../image/'+ mainArray[i]['img'] +'" height ="64px" width="64px">');
            x.push('<a href="home.php?module=listphoto&action=edit&_Id='+mainArray[i]['im_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listphoto|'+mainArray[i]['im_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Photo Title" },{ "sTitle": "Image", "sClass": "center" },
                  {"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makeClassList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['cl_id']);
            x.push(mainArray[i]['details']);
            
            x.push('<a href="home.php?module=listclass&action=edit&_Id='+mainArray[i]['cl_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listclass|'+mainArray[i]['cl_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Class Title" },
                  {"sTitle":"Action" , "sClass": "center"}];
        return finalArray;
   }
   function makeClassRep(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['cl_id']);
            x.push(mainArray[i]['details']);
            
            x.push('<a href="home.php?module=batch&action=view&_Id='+mainArray[i]['cl_id']+'"><img src="../img/view.png" height="16px" width="16"></a> ');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Class Title" },
                  {"sTitle":"View" , "sClass": "center"}];
        return finalArray;
   }
   function makeQuestionList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['que_id']);
            x.push(mainArray[i]['details']);
            
            x.push('<a href="home.php?module=listquestion&action=edit&_Id='+mainArray[i]['que_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listquestion|'+mainArray[i]['que_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "   Question Details    " },
                  {"sTitle":"Action" , "sClass": "center"}];
        return finalArray;
   }
   function makesubjectRep(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['sub_id']);
            x.push(mainArray[i]['details']);
            
            x.push('<a href="home.php?module=subject&action=edit&_Id='+mainArray[i]['sub_id']+'"><img src="../img/view.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Subject Title" },
                  {"sTitle":"View" , "sClass": "center"}];
        return finalArray;
   }
   function makeScheduleList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['sch_id']);
            x.push(mainArray[i]['subject']);
            x.push(mainArray[i]['class']);
            x.push(mainArray[i]['ex_qty']);
            x.push(mainArray[i]['ex_dur']/60+' mins');
            if(mainArray[i]['status']==0)
            {
                var strCond='<a href="home.php?module=listschedule&axn=conduct&_Id='+mainArray[i]['sch_id']+'"> <img src="../img/conduct.png" height="16px" width="16"></a> ';
            }
            else
            {
                var strCond='<a href="home.php?module=listschedule&axn=stop&_Id='+mainArray[i]['sch_id']+'"> <img src="../img/deactivate.png" height="16px" width="16"></a> ';
            }
            //alert(strCond);
            
            //alert('<a href="home.php?module=listexam&action=edit&_Id='+mainArray[i]['ex_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="'+mainArray[i]['ex_id']+'" href="'+window.location);
            x.push( strCond+ ' | <a href="home.php?module=listschedule&action=edit&_Id='+mainArray[i]['sch_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listschedule|'+mainArray[i]['sch_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a> ');
            //alert(mainArray[i]['year']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle":"Subject Title" },
                    { "sTitle":  "Class Details"},{"sTitle":"Qty" , "sClass": "center"}
                    ,{"sTitle":"Duration" , "sClass": "center"},{"sTitle":"Action" , "sClass": "center"}];
        return finalArray;
   }
    //home program welcome note right bottom text history testimonials contact
    function makeStaticList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['sch_id']);
            x.push(mainArray[i]['subject']);
            x.push(mainArray[i]['class']);
            x.push(mainArray[i]['ex_qty']);
            x.push(mainArray[i]['ex_dur']/60+' mins');
            //alert('<a href="home.php?module=listexam&action=edit&_Id='+mainArray[i]['ex_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="'+mainArray[i]['ex_id']+'" href="'+window.location);
            x.push('<a href="home.php?module=listschedule&action=conduct&_Id='+mainArray[i]['sch_id']+'"><img src="../img/conduct.png" height="16px" width="16"></a>| <a href="home.php?module=listschedule&action=edit&_Id='+mainArray[i]['sch_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="listschedule|'+mainArray[i]['sch_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a> ');
            //alert(mainArray[i]['year']);
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle":"Subject Title" },
                    { "sTitle":  "Class Details"},{"sTitle":"Qty" , "sClass": "center"}
                    ,{"sTitle":"Duration" , "sClass": "center"},{"sTitle":"Action" , "sClass": "center"}];
        return finalArray;
   }
   
   function makeTestList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['tes_id']);
            x.push(mainArray[i]['author']);
            
            x.push('<a href="home.php?module=testimonials&action=edit&_Id='+mainArray[i]['tes_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="testimonials|'+mainArray[i]['tes_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Author Name" },
                  {"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makeNoticeList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['note_id']);
            x.push(mainArray[i]['title']);
            
            x.push('<a href="home.php?module=notice&action=edit&_Id='+mainArray[i]['note_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="notice|'+mainArray[i]['note_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Title " },
                  {"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }
   function makePageList(mainArray )
   {
        finalArray=[];
        for(i=0;i<mainArray.length;i++)
        {
            x=[];
            x.push(i+1);
            x.push(mainArray[i]['m_id']);
            x.push(mainArray[i]['link']);
            
            x.push('<a href="home.php?module=page&action=edit&_Id='+mainArray[i]['m_id']+'"><img src="../img/edit.png" height="16px" width="16"></a> | <a id="page|'+mainArray[i]['m_id']+'" href="'+window.location+'#" onclick ="test(this.id)"><img src="../img/delete.png" height="16px" width="16"></a>');
            finalArray.push(x);
        }
        ColArray=[{ "sTitle": "Sn." },{ "sTitle": "ID" },{ "sTitle": "Title " },
                  {"sTitle":"Actions" , "sClass": "center"}];
        return finalArray;
   }