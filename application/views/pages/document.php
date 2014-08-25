<div class="well">
<p>GET</p>
<hr>
<a href="http://hangout.org.cn/api/activityList">activityList</a>
<a href="http://hangout.org.cn/api/checkActivityID/%id%">checkActivityID/%id%</a>
<a href="http://hangout.org.cn/api/checkActivitySlug/%slug%">checkActivitySlug/%slug%</a>
<a href="http://hangout.org.cn/api/getActivityInfo/%id%">getActivityInfo/%id%</a>
<a href="http://hangout.org.cn/api/getActivityTitle/%id%">getActivityTitle/%id%</a>
<a href="http://hangout.org.cn/api/getID/%slug%">getID/%slug%</a>
<a href="http://hangout.org.cn/api/getSlug/%id%">getSlug/%id%</a>
<a href="http://hangout.org.cn/api/adminLogout">adminLogout</a>
<a href="http://hangout.org.cn/api/userLogout/%id%">userLogout/%id%</a>
<a href="http://hangout.org.cn/api/getModelTimetable/%id%">getModelTimetable/%id%</a>
<a href="http://hangout.org.cn/api/getModelChatroom/%id%">getModelChatroom/%id%</a>
<a href="http://hangout.org.cn/api/getModelLocation/%id%">getModelLocation/%id%</a>
</div>

<div class="well">
<p>createActivity</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/createActivity">
<input name="title" placeholder="title"></input>
<input name="slug" placeholder="slug"></input>
<input name="model_timetable" placeholder="model_timetable [0/1]"></input>
<input name="model_chatroom" placeholder="model_chatroom [0/1]"></input>
<input name="model_location" placeholder="model_location [0/1]"></input>
<input name="password1" placeholder="password1"></input>
<input name="password2" placeholder="password2"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>joinActivity</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/joinActivity">
<input name="id" placeholder="id"></input>
<input name="username" placeholder="username"></input>
<input name="password1" placeholder="password1"></input>
<input name="password2" placeholder="password2"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>adminLogin</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/adminLogin">
<input name="id" placeholder="id"></input>
<input name="password" placeholder="password"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>updateActivityTitle [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/updateActivityTitle">
<input name="id" placeholder="id"></input>
<input name="title" placeholder="title"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>updateActivityInfo [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/updateActivityInfo">
<input name="id" placeholder="id"></input>
<input name="info" placeholder="info"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>updateActivitySlug [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/updateActivitySlug">
<input name="id" placeholder="id"></input>
<input name="slug" placeholder="slug"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>userLogin</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/userLogin">
<input name="id" placeholder="id"></input>
<input name="username" placeholder="username"></input>
<input name="password" placeholder="password"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>userUnregister [userLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/userUnregister">
<input name="id" placeholder="id"></input>
<input name="username" placeholder="username"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>getUserList [adminLogin]/[userLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/getUserList">
<input name="id" placeholder="id"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>removeUser [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/removeUser">
<input name="id" placeholder="id"></input>
<input name="username" placeholder="username"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>checkUser [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/checkUser">
<input name="id" placeholder="id"></input>
<input name="username" placeholder="username"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>setModelTimetable [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/setModelTimetable">
<input name="id" placeholder="id"></input>
<input name="state" placeholder="state [0/1]"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>setModelChatroom [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/setModelChatroom">
<input name="id" placeholder="id"></input>
<input name="state" placeholder="state [0/1]"></input>
<input type="submit"></input>
</form>
</div>

<div class="well">
<p>setModelLocation [adminLogin]</p>
<hr>
<form method="post" action="http://hangout.org.cn/api/setModelLocation">
<input name="id" placeholder="id"></input>
<input name="state" placeholder="state [0/1]"></input>
<input type="submit"></input>
</form>
</div>