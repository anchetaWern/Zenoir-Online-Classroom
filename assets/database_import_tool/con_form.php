<h1>User Information Import Tool</h1>
<p>
This tool is used to easily import existing user information into<br/>
the Zenoir database. All you have to do is to input the <br/>
database details of the source database(database where you're trying to import from)<br/>
The only thing that you need to remember when using this tool is that only users of a specific type<br/>
can be imported at a time. This means that you have to run this tool for each user type. <br/>
If your database stores users of different user types in a single table then this tool can't be use.<br/>
The following are the required data:<br/>
<ul>
	<li><strong>User ID</strong> - input the name of the field in your source database for the user id</li>
	<li><strong>Fname</strong> - input the name of the field in your source database for the first name</li>
	<li><strong>Mname</strong>- input the name of the field in your source database for the middle name</li>
	<li><strong>Mname</strong>- input the name of the field in your source database for the last name</li>
	<li>
	<strong>User Type</strong> - the following are the possible values for user type:
	<ul>
		<li>1 - for administrator</li>
		<li>2 - for teachers</li>
		<li>3 - for students</li>
	</ul>
	
	</li>
</ul>
</p>
<form action="post.php" method="post">
<input type="text" name="host" placeholder="host"/>
<input type="text" name="user" placeholder="user"/>
<input type="password" name="pword" placeholder="pword"/>
<input type="text" name="database" placeholder="database"/>
<input type="text" name="table" placeholder="table"/>
<p>
<input type="text" name="user_id" placeholder="user_id"/>
<input type="text" name="fname" placeholder="fname"/>
<input type="text" name="mname" placeholder="mname"/>
<input type="text" name="lname" placeholder="lname"/>
<input type="text" name="user_type" placeholder="user type"/>
</p>

<input type="submit" />
</form>