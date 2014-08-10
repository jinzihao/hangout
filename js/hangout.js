function createActivity(){
	var status=new Array();
	if(document.getElementById("timetable").className.indexOf("active")>=0){status[0]=1;}
	else if(document.getElementById("timetable").className.indexOf("active")==-1){status[0]=0;}
	if(document.getElementById("chatroom").className.indexOf("active")>=0){status[1]=1;}
	else if(document.getElementById("chatroom").className.indexOf("active")==-1){status[1]=0;}
	if(document.getElementById("location").className.indexOf("active")>=0){status[2]=1;}
	else if(document.getElementById("location").className.indexOf("active")==-1){status[2]=0;}
	$.post("activities/create",{title:document.getElementById("title").value, slug:document.getElementById("slug").value, model_timetable:status[0], model_chatroom:status[1], model_location:status[2], adminPassword:document.getElementById("adminPassword").value, adminPasswordAgain:document.getElementById("adminPasswordAgain").value},function(data){createActivity_check(data);});
}
	
function createActivity_check(result){
	result=$.parseJSON(result);
	if (result.success=="0")
	{
		if (result.error1=="0"){	
			document.getElementById("title_group").className="";
			document.getElementById("title").placeholder="";
			}
		if (result.error2=="0"){		
			document.getElementById("slug_group").className="";
			document.getElementById("slug").placeholder="";
			}
		if (result.error5=="0"){		
			document.getElementById("adminPassword_group").className="";
			document.getElementById("adminPassword").placeholder="";
			document.getElementById("adminPasswordAgain_group").className="";
			document.getElementById("adminPasswordAgain").placeholder="";
			}
		if (result.error3=="0"){		
			document.getElementById("adminPassword_group").className="";
			document.getElementById("adminPassword").placeholder="";
			}
		if (result.error4=="0"){		
			document.getElementById("adminPasswordAgain_group").className="";
			document.getElementById("adminPasswordAgain").placeholder="";
			}
		if (result.error6=="0"){		
			document.getElementById("slug_group").className="";
			document.getElementById("slug").placeholder="";
			}
		if (result.error1=="1"){	
			document.getElementById("title_group").className="has-error";
			document.getElementById("title").placeholder="请输入活动标题";
			}
		if (result.error2=="1"){		
			document.getElementById("slug_group").className="has-error";
			document.getElementById("slug").placeholder="请输入主页网址";
			}
		if (result.error3=="1"){		
			document.getElementById("adminPassword_group").className="has-error";
			document.getElementById("adminPassword").placeholder="请输入管理密码";
			}
		if (result.error4=="1"){		
			document.getElementById("adminPasswordAgain_group").className="has-error";
			document.getElementById("adminPasswordAgain").placeholder="请重复输入管理密码";
			}
		if (result.error5=="1"){		
			document.getElementById("adminPassword_group").className="has-error";
			document.getElementById("adminPasswordAgain_group").className="has-error";
			document.getElementById("adminPassword").value="";
			document.getElementById("adminPasswordAgain").value="";
			document.getElementById("adminPassword").placeholder="两次输入的密码不匹配";
			document.getElementById("adminPasswordAgain").placeholder="两次输入的密码不匹配";
			}
		if (result.error6=="1"){		
			document.getElementById("slug_group").className="has-error";
			document.getElementById("slug").value="";
			document.getElementById("slug").placeholder="该网址已被注册";
			}
	}
	else if (result.success=="1")
	{
		top.location="a/"+result.slug;
	}
}

function generateSlug(instr){
	$.post("utils/slug",{title:instr},function(data){document.getElementById("slug").value=data;});
}
