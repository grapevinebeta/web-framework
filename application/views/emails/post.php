<!DOCTYPE html PUBLIC
    "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN"
    "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Grapevine Export Document</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

  </head>
  <body>
      
    <div id="container">
        
      <div id="main">
       <div id="page" style="width:400px;">
           
           <p>This email was sent to you because someone felt it was of importance to you.‭ ‬
           This email does not subscribe you to any email list and is 
           purely a one-time notification email. </p>
           
           <h4><?php echo $data['title'] ?></h4>
           <p>
               <?php if(isset($data['score'])): ?>
                <strong>Score:</strong>  <?php echo $data['score'] ?>/5 <br>
               <?php endif; ?>
               <strong>Author:</strong> <?php echo $data['identity'] ?> posted <?php echo date('d M, Y', $data['date']); ?> at <?php echo $data['site'] ?></p>

           <p>
             <?php echo $data['content']; ?>
           </p>

           
           <hr />
           
            Thank you,‭ <br />
‬            <strong>Grapevine Team.‭ </strong><br />
<br /><br />
            ‬Log into your Dashboard now at‭ ‬<a href="http://www.pickgrapevine.com">http://www.pickgrapevine.com</a>
 
       </div>
      </div>
    </div>
  </body>
</html>