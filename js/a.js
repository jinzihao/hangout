function joinActivity(){
	$.post("/activities/join",{id:document.getElementById("id").value, username:document.getElementById("username").value, userPassword:document.getElementById("userPassword").value, userPasswordAgain:document.getElementById("userPasswordAgain").value},function(data){joinActivity_check(data);});
}
	
function joinActivity_check(result){
	result=$.parseJSON(result);
	if (result.status=="1")
	{
		if (result.error1=="0"){	
			document.getElementById("username_group").className="";
			document.getElementById("username").placeholder="";
			}
		if (result.error4=="0"){		
			document.getElementById("userPassword_group").className="";
			document.getElementById("userPassword").placeholder="";
			document.getElementById("userPasswordAgain_group").className="";
			document.getElementById("userPasswordAgain").placeholder="";
			}
		if (result.error2=="0"){		
			document.getElementById("userPassword_group").className="";
			document.getElementById("userPassword").placeholder="";
			}
		if (result.error3=="0"){		
			document.getElementById("userPasswordAgain_group").className="";
			document.getElementById("userPasswordAgain").placeholder="";
			}
		if (result.error1=="1"){	
			document.getElementById("username_group").className="has-error";
			document.getElementById("username").placeholder="请输入姓名";
			}
		if (result.error2=="1"){		
			document.getElementById("userPassword_group").className="has-error";
			document.getElementById("userPassword").placeholder="请输入密码";
			}
		if (result.error3=="1"){		
			document.getElementById("userPasswordAgain_group").className="has-error";
			document.getElementById("userPasswordAgain").placeholder="请重复输入密码";
			}
		if (result.error4=="1"){		
			document.getElementById("userPassword_group").className="has-error";
			document.getElementById("userPasswordAgain_group").className="has-error";
			document.getElementById("userPassword").value="";
			document.getElementById("userPasswordAgain").value="";
			document.getElementById("userPassword").placeholder="两次输入的密码不匹配";
			document.getElementById("userPasswordAgain").placeholder="两次输入的密码不匹配";
			}
	}
	else if (result.status=="2")
	{
			document.getElementById("username_group").className="has-error";
			document.getElementById("username").value="";
			document.getElementById("username").placeholder="该用户名已在此活动注册";
			document.getElementById("userPassword_group").className="";
			document.getElementById("userPassword").placeholder="";
			document.getElementById("userPasswordAgain_group").className="";
			document.getElementById("userPasswordAgain").placeholder="";
	}
	else if (result.status=="0")
	{
		alert("提交成功");
	}
}
