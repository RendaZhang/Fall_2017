<!DOCTYPE html>
<html>
<head>
<script src="check.js"></script>
</head>

<title>Question 1</title>
<body>
  <form action="index.php" method="post" onSubmit='return check("answer")'>
    <h1><font color="#660033">Gopher Sports</font></h1>
    <p>Which of the following former Gopher basesball players has been inducted into Major League Baseball Hall of Fame?<br>
    <br>
    <input name="action" value="Quiz" hidden>
    <input type="radio" name="answer" value="Glen Perkins">Glen Perkins<br>
    <input type="radio" name="answer" value="Terry Steinbach">Terry Steinbach<br>
    <input type="radio" name="answer" value="Dan Wilson">Dan Wilson<br>
    <input type="radio" name="answer" value="Dave Winfield">Dave Winfield<br>
    <br>
    <br>
    <input type="hidden" name="next" value="2">
    <input type="hidden" name="question" value="1">
    <input type="submit" name="Submit" value="Next"></p>
  </form>
</body></html>
