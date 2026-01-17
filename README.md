# TOTALREGLEMENTS POUR [DOLIBARR ERP & CRM](https://www.dolibarr.org)

## Fonctionnalités

Ce module est conçu pour les autoentrepreneurs.

Ce module permet d'analyser et de répartir les règlements selon la nature de l'activité exercée. Pour les autoentrepreneurs sous le régime BIC, il collecte automatiquement dans l'ensemble des règlements la part correspondant aux prestations de services (commerciales ou artisanales) et celle correspondant à la vente de marchandise (négoce). Cette distinction est essentielle pour calculer avec précision le montant des charges URSSAF et correctement renseigner votre déclaration de chiffre d'affaire, car les taux de cotisation diffèrent selon la nature de l'activité.
Une option a été ajoutée pour, permettre aux prestataires de service sous le régime BNC de calculer également le montant de leurs charges, et le CA à déclarer par trimestre ou mensuel.

<!--
![Capture d'écran totalreglements](img/screenshot_totalreglements.png?raw=true "TotalReglements"){imgmd}
-->

D'autres modules externes sont disponibles sur [Dolistore.com](https://www.dolistore.com).

## ⚠️ Avertissement et limitation de responsabilité

**CE MODULE EST FOURNI "EN L'ÉTAT", SANS GARANTIE D'AUCUNE SORTE.**

L'utilisation de ce module se fait sous votre entière responsabilité. L'auteur ne saurait être tenu responsable de toute erreur, inexactitude ou omission dans les calculs effectués par ce module, ni de leurs conséquences.

**Il est de votre responsabilité de :**
- Vérifier l'exactitude des calculs et des montants générés par le module
- Vous assurer de la conformité avec la réglementation fiscale et sociale en vigueur
- Contrôler vos déclarations avant de les transmettre aux organismes compétents (URSSAF, etc.)
- Consulter un expert-comptable ou un professionnel qualifié en cas de doute

**L'auteur décline toute responsabilité en cas de :**
- Erreurs dans les calculs de charges URSSAF ou de chiffre d'affaires
- Déclarations fiscales ou sociales incorrectes
- Pénalités, majorations ou redressements liés à l'utilisation du module
- Tout dommage direct ou indirect résultant de l'utilisation ou de l'impossibilité d'utiliser ce module

Chaque utilisateur reste seul responsable de ses obligations déclaratives et de la tenue de sa comptabilité conformément aux dispositions légales et réglementaires applicables.

## Traductions

Les traductions peuvent être complétées manuellement en éditant les fichiers dans les répertoires du module sous `langs`.

<!--
Ce module contient également un exemple de configuration pour Transifex, dans le répertoire caché [.tx](.tx), il est donc possible de gérer la traduction en utilisant ce service.

Pour plus d'informations, consultez la [documentation du traducteur](https://wiki.dolibarr.org/index.php/Translator_documentation).

Il existe un [projet Transifex](https://transifex.com/projects/p/dolibarr-module-template) pour ce module.
-->


## Installation

Prérequis : Vous devez avoir le logiciel Dolibarr ERP & CRM installé. Vous pouvez le télécharger depuis [Dolistore.org](https://www.dolibarr.org).
Vous pouvez également obtenir une instance prête à l'emploi dans le cloud sur https://saas.dolibarr.org


### Depuis le fichier ZIP et l'interface graphique

Si le module est un fichier zip prêt à être déployé, avec un nom `module_xxx-version.zip` (par exemple, lors du téléchargement depuis une marketplace comme [Dolistore](https://www.dolistore.com)),
allez dans le menu `Accueil > Configuration > Modules > Déployer un module externe` et téléchargez le fichier zip.

Note : Si cet écran vous indique qu'il n'y a pas de répertoire "custom", vérifiez que votre configuration est correcte :

<!--

- Dans le répertoire d'installation de Dolibarr, éditez le fichier `htdocs/conf/conf.php` et vérifiez que les lignes suivantes ne sont pas commentées :

    ```php
    //$dolibarr_main_url_root_alt ...
    //$dolibarr_main_document_root_alt ...
    ```

- Décommentez-les si nécessaire (supprimez le `//` au début) et attribuez la valeur appropriée selon votre installation Dolibarr

    Par exemple :

    - UNIX :
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = '/var/www/Dolibarr/htdocs/custom';
        ```

    - Windows :
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = 'C:/My Web Sites/Dolibarr/htdocs/custom';
        ```
-->

<!--

### Depuis un dépôt GIT

Clonez le dépôt dans `$dolibarr_main_document_root_alt/totalreglements`

```shell
cd ....../custom
git clone git@github.com:gitlogin/totalreglements.git totalreglements
```

-->

### Étapes finales

En utilisant votre navigateur :

  - Connectez-vous à Dolibarr en tant que super-administrateur
  - Allez dans "Configuration" > "Modules"
  - Vous devriez maintenant pouvoir trouver et activer le module



## Licences

### Code principal

GPLv3 ou (à votre choix) toute version ultérieure. Voir le fichier COPYING pour plus d'informations.

### Documentation

Tous les textes et readme sont sous licence [GFDL](https://www.gnu.org/licenses/fdl-1.3.en.html).
