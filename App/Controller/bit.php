<?php
namespace App\Controller;

/**
*
*/
class bit
{

    public function bit(){
    if(!($file = fopen("src/img/claque.gif","rb"))) //ouvre le fichier
    {
        print("fichier pas ouvrable") ;
        exit;
    }

    print("Taille du fichier : ") ;     //
    print(filesize("src/img/claque.gif")) ;     // Affiche la taille du fichier
    print(" octets <br><br>") ;         //

    $taille = filesize("src/img/claque.gif") ;
    $i = 0 ;
    $enter = 0 ;

    $do = '';
    while($i <= $taille)   //Boucle affichant le fichier octets par octets
    {
        $a = unpack ('C1', fread($file, 1));
        if(isset($a) && isset($a[1]) && $a[1] >= 65 && $a[1] <= 122)
                file_put_contents('src/img/tata.txt', chr($a[1]), FILE_APPEND);
        $i += 1 ;
    }
    //   /* Open the image file in binary mode */
    // if(!$fp = fopen ("src/img/claque.gif", 'rb')) return 0;

    // /* Read 20 bytes from the top of the file */
    // if(!$data = fread ($fp, 200000)) return 0;

    // /* Create a format specifier */
    // $header_format =
    //         'A6Version/' . # Get the first 6 bytes
    //         'C2Width/' .   # Get the next 2 bytes
    //         'C2Height/' .  # Get the next 2 bytes
    //         'C1Flag/' .    # Get the next 1 byte
    //         '@11/' .       # Jump to the 12th byte
    //         'C1Aspect/' .   # Get the next 1 byte
    //         'AC*All';
    // /* Unpack the header data */
    // $header = unpack ($header_format, $data);

    // $ver = $header['Version'];

    // if($ver == 'GIF87a' || $ver == 'GIF89a') {
    //     var_dump($header);
    // } else {
    //     return 0;
    // }
}

}

?>
