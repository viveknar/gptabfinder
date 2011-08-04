#!/usr/bin/php -q
<?php


    include_once("./snoopy.class.php");

    include_once("./htmlsql.class.php");

    

    $wsql = new htmlsql();
    $sqlh = new htmlsql();

    
    $query = "";
    for($i = 1; $i<$argc;$i++)
    {
        $query .= $argv[$i].'+';
    }
    $query = trim($query, '+');


    // connect to url 

    if (!$wsql->connect('url', 'http://www.ultimate-guitar.com/search.php?type=500&order=myweight&&rating%5B%5D=5&rating%5B%5D=4&rating%5B%5D=3&title='.$query)){

        print 'Error while connecting: ' . $wsql->error;

        exit;

    }

    

    /* execute a query:

       This query extracts all links from the document

       and just returns href (as url) and text

    */

    if (!$wsql->query('SELECT href as url, text FROM a where $class == "song"')){

        print "Query error: " . $wsql->error; 

        exit;

    }



    foreach ($wsql->fetch_array() as $row) {
	if(preg_match('/http:\/\/www.ultimate-guitar.com\//', $row['text'])) {
		print "link to band tabs: http://www.ultimate-guitar.com/".$row['text'];
	}
	else {
		print "Song name: ".$row['text']."\n";
		print "guitar pro download link: ".$row['url']."\n\n"; 	
	}
    }

        

    

    

?>
