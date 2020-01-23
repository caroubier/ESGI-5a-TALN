<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use SpotifyWebAPI;
use App\Entity\LyricEntity;
use Doctrine\ORM\EntityManager;

class AuthController extends AbstractController
{

    private $spotifyParams;
    private $spotify; 


    public function __construct()
    {
        $this->spotifyParams = [
            'client_id' => 'eb5d989e27f34e30a8eb12dec9039937',
            'client_secret' => '8098f28b1d7044a9a1b4a933159a5525',
            'redirect_uri' => 'http://127.0.0.1:8000/callback/', 
            'scope' => ['user-read-email','user-read-private','playlist-read-private',
                         'playlist-read-collaborative','playlist-modify-public',
                         'playlist-modify-private','user-follow-read','user-follow-modify']
        ];

        $this->spotify = new SpotifyWebAPI\Session(
            $this->spotifyParams['client_id'],
            $this->spotifyParams['client_secret'],
            'http://127.0.0.1:8000/login/oauth'
        );

    }

    /**
     * @Route("/login", name="login")
     */
    public function login( SessionInterface $session )
    {

        $options = [
            'scope' => $this->spotifyParams['scope']
        ];

        $spotify_auth_url = $this->spotify->getAuthorizeUrl($options);

        return $this->render('auth/login.html.twig', array(
            'spotify_auth_url' => $spotify_auth_url

        ));
    }

    /**
     * @Route("/login/oauth", name="oauth")
     */
    public function oauth(Request $request, SessionInterface $session) 
    {

      
        $accessCode = $request->get('code');
        $session->set('accessCode', $accessCode); // symfony session

         
        $this->spotify->requestAccessToken($accessCode);
        $accessToken = $this->spotify->getAccessToken();
        $session->set('accessToken', $accessToken); // symfony session
        
        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, SessionInterface $session )
    {
      
        $accessToken = $session->get('accessToken');
        if( !$accessToken ) {
            $session->getFlashBag()->add('error', 'Invalid authorization');
            $this->redirectToRoute('login');
            
        }

         
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
 
       
        $me = $api->me();
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('post')){
           
                 
                //dump($api->getPlaylist("37i9dQZF1DXa7FSukIBTlS"));die(); 

                /*le but est de chercher par GENRE de Musique 
                et de renvoyer toute les musique du genre/(topic)que j'ai choisi préalablement 
                */
             if ($_POST['submit'] == "searche"){
                $lyrics_charged =null ;
                    $to_searche = $_POST['to_searche'];    
                    $result = $api->search($to_searche,'playlist');
                    //dump($result);die();
                    $nombre_track = 0 ;
                        foreach ($result as $artist){
                            $resultat[]= $artist->items ;  
                            foreach($resultat as $song ){
                                foreach($song as $a){
                                    $result_search[] = $a ;
                                //dump($result_search->total) ;die(); 
                                foreach($result_search as $nb ){ 
                                    $nombre_track += $nb->tracks->total ;
                                }
                                } 
                            }
                        }
                        //if recherche Statistique
                        $nombre_chanson = count($result_search) ; 
                 } 
            // dump($_POST['submit']);die();
             if ($_POST['submit'] == "importer"){
                $path="upload/";
                    extract(filter_input_array(INPUT_POST)); 
                    $fichier = $_FILES["userfile"]["name"] ;
                
                   
                    if ($fichier){
                        $fp = fopen($_FILES["userfile"]["tmp_name"],"r");
                       
                    }else{
                        $this->addFlash('warning','Ne peut pas ouvire le fichier ! ');
                    }
                    $cpt = 0;
                    while(!feof($fp)){
                        
                        $ligne = fgets($fp,10485761);
                        $liste = explode(",",$ligne) ;
                         
                        $table = filter_input(INPUT_POST,'userfile');
                     
                        //premier element 
                        for ($i = 0 ; $i<=0; $i++){
                         $ligne[$i] = (isset($liste[$i])) ? $liste[$i] : Null ;
                        } 
                        dump($ligne);
                        /*
                        $ligne[1]= (isset($liste[1])) ? $liste[1] : Null ;
                        $ligne[2]= (isset($liste[2])) ? $liste[2] : Null ;
                        $ligne[3]= (isset($liste[3])) ? $liste[3] : Null ;
                        $ligne[4]= (isset($liste[4])) ? $liste[4] : Null ;
                        $ligne[5]= (isset($liste[5])) ? $liste[5] : Null ;
                        $ligne[6]= (isset($liste[6])) ? $liste[6] : Null ;
                        $ligne[7]= (isset($liste[7])) ? $liste[7] : Null ;
                        $ligne[8]= (isset($liste[8])) ? $liste[8] : Null ;
                        $ligne[9]= (isset($liste[9])) ? $liste[9] : Null ;
                        $ligne[10]= (isset($liste[10])) ? $liste[10] : Null ;
                        $ligne[11]= (isset($liste[11])) ? $liste[11] : Null ;
                        $ligne[12]= (isset($liste[12])) ? $liste[12] : Null ;
                        */
                     
                        for($j=0; $j < 15; $j++){ 
                           $champ[$j] = $liste[$j] ;
                            }
                            
                       dump($champ);//die();

                        if ($champ[0] != ''){
                            $cpt++ ;
                            
                            $lyrics =  new LyricEntity();
                            //dump($lyrics);die();
                            $lyrics->setId1($champ[0]) ;
                            $lyrics->setSong($champ[1]) ;
                            $lyrics->setAnnee($champ[2]) ;
                            $lyrics->setArtist($champ[3]) ;
                            $lyrics->setGenre($champ[4]) ;
                            $lyrics->setWord0($champ[5]) ;
                            $lyrics->setWord1($champ[6]) ;
                            $lyrics->setWord2($champ[7]) ;
                            $lyrics->setWord3($champ[8]) ;
                            $lyrics->setWord4($champ[9]) ;
                            $lyrics->setWord5($champ[10]) ;
                            $lyrics->setWord6($champ[11]) ;
                            $lyrics->setWord7($champ[12]) ;
                            $lyrics->setWord8($champ[13]) ;
                            $lyrics->setWord9($champ[14]) ;
                            
                            dump($lyrics); 
                         
                            $em->persist($lyrics);      
                            $em->flush();
                            $this->addFlash('success','Fichier chargé avec succée ! ');
                        }
                    }
                    fclose($fp) ;  
            }
        
         }else {
                // par défaut j'affiche les donnée de la BDD 
                $result_search = null ;
                $lyrics_charged = $em->getRepository(LyricEntity::class)->findAll(); 
                $nombre_chanson = count($lyrics_charged) ;
                 //dans ce cas il faut trouver combien de type de musique il y'en a 
                
                $nombre_track =$nombre_chanson ;
                $to_searche = null ;
                /* $result = $api->search('PNL','artist');
                 foreach ($result->artists->items as $artist){
                
                     if($artist->name =="PNL")
                     {
                         $result_search[]= $artist;
                     }
                 }
                 $nombre_chanson = 2  ; 
                 $nombre_track = 2 ;    
                 $to_searche = "PNL";    */
             }
        
        //Creation du disctionnaire 
   
      //dump($result_search);die();
       /*  foreach($result_search as $res ){
             foreach($res->images as $img){
                dump($img->url);
             }
         }   
         */
        dump($result_search);//die();

         return $this->render('auth/profile.html.twig', array(
            'me' => $me,
            'result' => $result_search,
            'nbr_song' => $nombre_chanson ,
            'nombre_track' => $nombre_track,
            'lyrics' => $lyrics_charged,
            'Topic' => $to_searche, 
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout( SessionInterface $session )
    {
        $session->clear();
        $session->getFlashBag()->add('success', 'You have successfully logged out');

        return $this->redirectToRoute('login');
    }

}

?>