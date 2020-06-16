<!DOCTYPE html>
<html>
  
<head>
<script src="check.js"></script>
</head>

  <title>Question 3</title>

<body>
  <form action="index.php" method="post" onSubmit='return check("answer")'>
    <h1><font color="#660033">Gopher Sports</font></h1>

    <p> How many times have the Gophers won the National Championship in College Football?<br>
    <br>
    <input name="action" value="Quiz" hidden>
    <input type="radio" name="answer" value="0"> 0 <br>
    <input type="radio" name="answer" value="2"> 2 <br>
    <input type="radio" name="answer" value="4"> 4 <br>
    <input type="radio" name="answer" value="7"> 7 <br>
    <br>
    <input type="hidden" name="question" value="3">
    <input type="hidden" name="next" value="4">
    <input type="submit" name="Submit" value="Finish"></p>
  </form>

</body></html>
