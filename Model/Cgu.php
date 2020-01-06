<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux commentaires
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Cgu extends Model
{
  public function conditions() {
    $websitename = WEBSITE_NAME;
    $webmastermail = WEBMASTER_EMAIL;
    $text = "
    <h2>Conditions Générales d'Utilisation.</h2>
    <p>En devenant membre du site, vous vous engagez à avoir pris connaissance des Conditions Générales d'Utilisation du site, définies ci-dessous :</p>

    <h3>1. Confidentialité</h3>
    <p>Vos données personnelles postées ou renseignées sur <strong>$websitename</strong> ne sont pas utilisées à des fins publicitaires ou commerciales. Elles sont strictement confidentielles.
    Nous nous soucions de la confidentialité et de la sécurité de vos informations personnelles. Nous mettons en œuvre une politique de sécurité afin de garantir la confidentialité de vos données personnelles. Cependant, aucune méthode de transmission et de stockage des données n'est totalement sûre et nous ne pouvons donc pas vous garantir la sécurité totale des informations transmises ou stockées par <strong>$websitename</strong>.</p>

    <h3>2. Noms d'utilisateurs et informations postées</h3>
    <p>Les commentaires et les autres informations que vous postez sur le forum, les sections commentaires, sur les pages du site situées sur les réseaux sociaux (Facebook, Twitter, Instagram, YouTube...) peuvent être vus et téléchargés par des internautes. Pour cette raison, nous vous encourageons à faire attention aux informations que vous postez sur <strong>$websitename</strong> et qui peuvent permettre votre identification.</p>

    <h3>3. Informations collectées automatiquement</h3>
    <p>Les informations enregistrées sur <strong>$websitename</strong> (telles que les login, mots de passe, adresses e-mail, informations personnelles) sont strictement personnelles et ne sont pas divulguées à des tiers pour des fins commerciales.
    Néanmoins, certaines informations sont enregistrées automatiquement : nous pouvons enregistrer l'adresse ip, le système d'exploitation et le navigateur utilisés par les utilisateurs du site. Nous pouvons aussi être capable de déterminer le fournisseur d'accès et les informations géographiques du point de connexion de l'utilisateur. Différents outils sont utilisés pour collecter ces informations. Certaines informations sont collectées par des cookies (petit fichier texte placé sur votre ordinateur). Vous êtes en mesure de contrôler comment et si oui ou non les cookies sont acceptés par votre navigateur. La plupart des navigateurs donnent des instructions sur comment configurer le navigateur pour qu'il rejette les cookies. Notez que si vous refusez l'utilisation des cookies, certaines fonctionnalités du site pourraient ne pas fonctionner ou mal fonctionner.
    Seules les autorités compétentes (Police et Justice) peuvent faire exiger la consultation de ces données à des fins légales.</p>

    <h3>4. Droit à la modification et à la suppression des données</h3>
    <p>Chaque membre du site peut modifier ses données personnelles via son compte. La modification des données peut se faire en cliquant sur le lien suivant : <a target='_blank'
    href='user/useredit'>Edition du compte.</a>
    Chaque membre peut également demander la suppression de son compte. Pour cela, il doit écrire à <a href='mailto:$webmastermail'>$webmastermail</a></p>

    <h3>5. Liens vers d'autres sites</h3>
    <p>Le site peut contenir des liens vers d'autres sites web publiés par d'autres organisations. Ces autres sites web ne sont pas sous notre contrôle, et, vous reconnaissez et acceptez que nous ne sommes pas responsables de la collecte d'informations par ces sites web. Nous vous encourageons à prendre connaissance de la politique de confidentialité de chaque site que vous visitez et utilisez.</p>

    <h3>6. Changement de politique de confidentialité</h3>
    <p>Notez que nous pouvons faire des modifications à cette politique de confidentialité de temps en temps. Tout changement de cette politique de confidentialité sera effectif immédiatement avec une date d'effet mise à jour. En accédant à ce site après que les changements aient été publiés, vous signifiez votre acceptation de la politique de confidentialité modifiée.</p>

";
  return $text;
  }



}
