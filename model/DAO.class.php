<? php
include_once("RSS.class.php");
include_once("Nouvelle.class.php");

class DAO {
        private $db; // L'objet de la base de donnée

        // Ouverture de la base de donnée
        function __construct() {
          $dsn = 'sqlite:rss.db'; // Data source name
          try {
            $this->db = new PDO($dsn);
          } catch (PDOException $e) {
            exit("Erreur ouverture BD : ".$e->getMessage());
          }
        }

        //////////////////////////////////////////////////////////
        // Methodes CRUD sur RSS
        //////////////////////////////////////////////////////////

        // Crée un nouveau flux à partir d'une URL
        // Si le flux existe déjà on ne le crée pas
        function createRSS($url) {
          $rss = $this->readRSSfromURL($url);
          if ($rss == NULL) {
            try {
              $q = "INSERT INTO RSS (url) VALUES ('$url')";
              $r = $this->db->exec($q);
              if ($r == 0) {
                die("createRSS error: no rss inserted\n");
              }
              return $this->readRSSfromURL($url);
            } catch (PDOException $e) {
              die("PDO Error :".$e->getMessage());
            }
          } else {
            // Retourne l'objet existant
            return $rss;
          }
        }

        // Acces à un objet RSS à partir de son URL
        function readRSSfromURL($url) {
         	//construction de la requete
				$q = "SELECT * FROM RSS WHERE url='".$url."'";
				$r = $this->db->query($q);
				//envoi du resultat (== NULL si resultat vide)
				if (!$r){
					return NULL;
				} else {
				return $r;
			}
        }

        // Met à jour un flux
        function updateRSS(RSS $rss) {
          // Met à jour uniquement le titre et la date
          $titre = $this->db->quote($rss->titre());
          $q = "UPDATE RSS SET titre=$titre, date='".$rss->date()."' WHERE url='".$rss->url()."'";
          try {
            $r = $this->db->exec($q);
            if ($r == 0) {
              die("updateRSS error: no rss updated\n");
            }
          } catch (PDOException $e) {
            die("PDO Error :".$e->getMessage());
          }
        }

        //////////////////////////////////////////////////////////
        // Methodes CRUD sur Nouvelle
        //////////////////////////////////////////////////////////

        // Acces à une nouvelle à partir de son titre et l'ID du flux
        function readNouvellefromTitre($titre,$RSS_id) {
			  //construction de la requete
 			 $q = "SELECT * FROM nouvelle WHERE titre='".$titre."' and RSS_id='".$RSS_id."'";;
 			 $r = $this->db->query($q);
 			 //envoi du resultat (== NULL si resultat vide)
 			 if (!$r){
 				 return NULL;
 			 } else {
 			 return $r;
 		 	 }
        }

        // Crée une nouvelle dans la base à partir d'un objet nouvelle
        // et de l'id du flux auquelle elle appartient
        function createNouvelle(Nouvelle $n, $RSS_id) {
			  $news = $this->readNouvellefromTitre($n->titre, $RSS_id);
			  if ($new == NULL) {
				 try {
					$q = "INSERT INTO nouvelle (titre, RSS_id) VALUES ('.$n->titre.', '.$RSS_id.')";
					$r = $this->db->exec($q);
					if ($r == 0) {
					  die("createRSS error: no rss inserted\n");
					}
					return $this->readNouvellefromTitre($n->titre, $RSS_id);
				 } catch (PDOException $e) {
					die("PDO Error :".$e->getMessage());
				 }
			  } else {
				 // Retourne l'objet existant
				 return $news;
			  }
        }

        // Met à jour le champ image de la nouvelle dans la base
        function updateImageNouvelle(Nouvelle $n) {
			  // Met à jour uniquement le titre et la date
           $titre = $this->db->quote($rss->titre());
           $q = "UPDATE nouvelle SET "
           try {
             $r = $this->db->exec($q);
             if ($r == 0) {
               die("updateRSS error: no news updated\n");
             }
           } catch (PDOException $e) {
             die("PDO Error :".$e->getMessage());
           }

        }
?>
