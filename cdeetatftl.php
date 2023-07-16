<?php
	defined('_JEXEC') or die('Access deny');

	class plgContentCdeetatftl extends JPlugin //Concatener à "plg" le nom du groupe (ici Content) puis le nom du plugin ( que l'on trouve ds le XML ligne extension) : plg<Plugin Group><Plugin name>
	{
		function onContentPrepare($content, $article, $params, $limit){	
			$document = JFactory::getDocument();
			$document->addStyleSheet('plugins/content/cdeetatftl/stylecdeetatftl.css');
			
			$re = '/{cef}(|.*){\/cef}/m';	
			preg_match_all($re, $article->text, $matches, PREG_SET_ORDER, 0);
			
			$b = explode('|',$matches[0][1]);
			

			$a  = '<div class="container-fluid">';
			$a .=  '<div class="titre">Etapes du projet</div>';
			$a .=   '<div class="explications">Vous trouverez ici l\'étape d\'avancement du projet. En passant la souris sur la dénomination de l\'étape, vous saurez à quoi elle se réfère</div>';
			$a .=   '<ul class="list-unstyled multi-steps">';
			$pass = 0;//bool
			
			
			foreach ($b as $ligne)
			{
				if ((substr($ligne,-1,1)=="]") && (substr($ligne,0,1)=="["))
				{
					if ($c=count($b)) //pour ne pas afficher le dernier ">"
					{
						$a .=   "<li class=\"is-active\">".substr($ligne,1,-1)	."<span class=\"separateur\" id=\"separateur\"> > </span></li>\r\n";
					}
					else
					{
						$a .=   "<li class=\"is-active\">".substr($ligne,1,-1)	."</li>\r\n";
					}
					
					$pass=1;
				}
				else
				{
					if ($pass == 0)
					{
						if ($c=count($b)) //pour ne pas afficher le dernier ">"
						{
							$a .=   "<li class=\"avant\">".$ligne."<span  class=\"separateur\" id=\"separateur-".$ligne."\"> > </span></li>\r\n";
						}
						else
						{
							$a .=   "<li class=\"avant\">".$ligne."<span class=\"separateur\" id=\"separateur-".$ligne."\"> > </span></li>\r\n";
						}
					}
					else
					{
						if ($c=count($b)) //pour ne pas afficher le dernier ">"
						{
							$a .=   "<li class=\"apres\">".$ligne."<span class=\"separateur\"  id=\"separateur-".$ligne."\"> > </span></li>\r\n";
						}
						else
						{
							$a .=   "<li class=\"apres\">".$ligne."</li>\r\n";
						}
					}
					
				}
				
			}
			
			$a .=   "</ul>";
			$a .=   "</div>";

			$article->text = preg_replace($re, $a, $article->text);
		}
	}
?>