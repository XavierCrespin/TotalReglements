<?php

require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/date.lib.php';
require_once DOL_DOCUMENT_ROOT.'/compta/facture/class/facture.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';

$langs->load("totalreglements@totalreglements");

llxHeader('', 'Total des règlements');

$annee_actuelle = date('Y');

echo '<form method="POST" action="">
        <label for="periodicite">Périodicité :</label>
        <select name="periodicite" id="periodicite" required>
            <option value="trimestriel" '.(isset($_POST['periodicite']) && $_POST['periodicite'] == 'trimestriel' ? 'selected' : (!isset($_POST['periodicite']) ? 'selected' : '')).'>Trimestrielle</option>
            <option value="mensuel" '.(isset($_POST['periodicite']) && $_POST['periodicite'] == 'mensuel' ? 'selected' : '').'>Mensuelle</option>
        </select>
        
        <br><br>
        
        <div id="champs_trimestre">
            <label for="trimestre">Trimestre :</label>
            <select name="trimestre" id="trimestre">
                <option value="1" '.(isset($_POST['trimestre']) && $_POST['trimestre'] == '1' ? 'selected' : '').'>1er trimestre (Jan-Mar)</option>
                <option value="2" '.(isset($_POST['trimestre']) && $_POST['trimestre'] == '2' ? 'selected' : '').'>2ème trimestre (Avr-Juin)</option>
                <option value="3" '.(isset($_POST['trimestre']) && $_POST['trimestre'] == '3' ? 'selected' : '').'>3ème trimestre (Juil-Sep)</option>
                <option value="4" '.(isset($_POST['trimestre']) && $_POST['trimestre'] == '4' ? 'selected' : '').'>4ème trimestre (Oct-Déc)</option>
            </select>
            <br><br>
        </div>
        
        <div id="champs_mois" style="display:none;">
            <label for="mois">Mois :</label>
            <select name="mois" id="mois">
                <option value="1" '.(isset($_POST['mois']) && $_POST['mois'] == '1' ? 'selected' : '').'>Janvier</option>
                <option value="2" '.(isset($_POST['mois']) && $_POST['mois'] == '2' ? 'selected' : '').'>Février</option>
                <option value="3" '.(isset($_POST['mois']) && $_POST['mois'] == '3' ? 'selected' : '').'>Mars</option>
                <option value="4" '.(isset($_POST['mois']) && $_POST['mois'] == '4' ? 'selected' : '').'>Avril</option>
                <option value="5" '.(isset($_POST['mois']) && $_POST['mois'] == '5' ? 'selected' : '').'>Mai</option>
                <option value="6" '.(isset($_POST['mois']) && $_POST['mois'] == '6' ? 'selected' : '').'>Juin</option>
                <option value="7" '.(isset($_POST['mois']) && $_POST['mois'] == '7' ? 'selected' : '').'>Juillet</option>
                <option value="8" '.(isset($_POST['mois']) && $_POST['mois'] == '8' ? 'selected' : '').'>Août</option>
                <option value="9" '.(isset($_POST['mois']) && $_POST['mois'] == '9' ? 'selected' : '').'>Septembre</option>
                <option value="10" '.(isset($_POST['mois']) && $_POST['mois'] == '10' ? 'selected' : '').'>Octobre</option>
                <option value="11" '.(isset($_POST['mois']) && $_POST['mois'] == '11' ? 'selected' : '').'>Novembre</option>
                <option value="12" '.(isset($_POST['mois']) && $_POST['mois'] == '12' ? 'selected' : '').'>Décembre</option>
            </select>
            <br><br>
        </div>
        
        <label for="annee">Année :</label>
        <input type="number" name="annee" id="annee" min="2000" max="2100" value="'.(isset($_POST['annee']) ? $_POST['annee'] : $annee_actuelle).'" required>
        
        <br><br>
        
        <label for="regime_fiscal">Régime fiscal :</label>
        <select name="regime_fiscal" id="regime_fiscal">
            <option value="BIC" '.(isset($_POST['regime_fiscal']) && $_POST['regime_fiscal'] == 'BIC' ? 'selected' : '').'>BIC</option>
            <option value="BNC" '.(isset($_POST['regime_fiscal']) && $_POST['regime_fiscal'] == 'BNC' ? 'selected' : '').'>BNC</option>
        </select>
        
        <br><br>
        
        <label for="formation_prof">Formation prof. obligatoire (%) :</label>
        <input type="number" name="formation_prof" step="0.01" value="'.(isset($_POST['formation_prof']) ? $_POST['formation_prof'] : '0.10').'" required>
        
        <br><br>
        
        <div id="champs_cci">
            <label for="taxe_cci_vente">Taxe CCI vente obligatoire (%) :</label>
            <input type="number" name="taxe_cci_vente" step="0.01" value="'.(isset($_POST['taxe_cci_vente']) ? $_POST['taxe_cci_vente'] : '0.02').'">
            
            <br><br>
            
            <label for="taxe_cci_prestation">Taxe CCI prestation obligatoire (%) :</label>
            <input type="number" name="taxe_cci_prestation" step="0.01" value="'.(isset($_POST['taxe_cci_prestation']) ? $_POST['taxe_cci_prestation'] : '0.04').'">
            
            <br><br>
        </div>
        
        <input type="hidden" name="token" value="' . newToken() . '">
        <input type="submit" class="button" value="Calculer">
      </form>';

echo '<script>
        function toggleChampsCI() {
            var regime = document.getElementById("regime_fiscal").value;
            var champsCCI = document.getElementById("champs_cci");
            if (regime === "BNC") {
                champsCCI.style.display = "none";
            } else {
                champsCCI.style.display = "block";
            }
        }
        
        function togglePeriodicite() {
            var periodicite = document.getElementById("periodicite").value;
            var champsTrimestre = document.getElementById("champs_trimestre");
            var champsMois = document.getElementById("champs_mois");
            
            if (periodicite === "mensuel") {
                champsTrimestre.style.display = "none";
                champsMois.style.display = "block";
            } else {
                champsTrimestre.style.display = "block";
                champsMois.style.display = "none";
            }
        }
        
        // Appeler au chargement de la page
        toggleChampsCI();
        togglePeriodicite();
        
        // Appeler lors du changement de sélection
        document.getElementById("regime_fiscal").addEventListener("change", toggleChampsCI);
        document.getElementById("periodicite").addEventListener("change", togglePeriodicite);
      </script>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Désactiver temporairement la vérification du token pour test
    // if (!isset($_POST['token']) || !verifyToken($_POST['token'])) {
    //     die('<p>Token CSRF invalide</p>');
    // }

    // Récupération de la périodicité et de l'année
    $periodicite = $_POST['periodicite'] ?? 'trimestriel';
    $annee = intval($_POST['annee'] ?? date('Y'));
    
    // Calcul des dates de début et fin selon la périodicité
    if ($periodicite == 'mensuel') {
        $mois = intval($_POST['mois'] ?? 1);
        
        // Tableau des noms de mois
        $noms_mois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];
        
        // Date de début : 1er jour du mois
        $date_debut = $annee . '-' . sprintf('%02d', $mois) . '-01';
        
        // Date de fin : dernier jour du mois
        $dernier_jour = date('t', strtotime($date_debut));
        $date_fin = $annee . '-' . sprintf('%02d', $mois) . '-' . $dernier_jour;
        
        $libelle_periode = $noms_mois[$mois];
        
    } else {
        // Mode trimestriel
        $trimestre = intval($_POST['trimestre'] ?? 1);
        
        switch($trimestre) {
            case 1:
                $date_debut = $annee . '-01-01';
                $date_fin = $annee . '-03-31';
                $libelle_periode = '1er trimestre';
                break;
            case 2:
                $date_debut = $annee . '-04-01';
                $date_fin = $annee . '-06-30';
                $libelle_periode = '2ème trimestre';
                break;
            case 3:
                $date_debut = $annee . '-07-01';
                $date_fin = $annee . '-09-30';
                $libelle_periode = '3ème trimestre';
                break;
            case 4:
                $date_debut = $annee . '-10-01';
                $date_fin = $annee . '-12-31';
                $libelle_periode = '4ème trimestre';
                break;
            default:
                die('<p>Trimestre invalide</p>');
        }
    }
    
    echo '<p><strong>Période : ' . $libelle_periode . ' ' . $annee . '</strong></p>';
    echo '<p>Du ' . dol_print_date(strtotime($date_debut), 'day') . ' au ' . dol_print_date(strtotime($date_fin), 'day') . '</p>';
    
    // Récupération des paramètres de calcul des charges
    $regime_fiscal = $_POST['regime_fiscal'] ?? 'BIC';
    $formation_prof = floatval($_POST['formation_prof'] ?? 0.10);
    $taxe_cci_vente = floatval($_POST['taxe_cci_vente'] ?? 0.02);
    $taxe_cci_prestation = floatval($_POST['taxe_cci_prestation'] ?? 0.04);
    
    // Échappement des dates pour SQL
    $date_fin_exclusive = date('Y-m-d', strtotime($date_fin . ' +1 day'));
    $date_debut = $db->escape($date_debut);
    $date_fin_exclusive = $db->escape($date_fin_exclusive);

    $sql = "SELECT typed_totals.product_type, SUM(typed_totals.total) AS total
            FROM (
                SELECT COALESCE(fd.product_type, 1) AS product_type,
                    SUM(pf.amount * fd.total_ttc / fl.total_ttc) AS total
                FROM ".MAIN_DB_PREFIX."paiement p
                JOIN ".MAIN_DB_PREFIX."paiement_facture pf ON p.rowid = pf.fk_paiement
                JOIN ".MAIN_DB_PREFIX."facture f ON pf.fk_facture = f.rowid
                JOIN (
                    SELECT fk_facture, SUM(total_ttc) AS total_ttc
                    FROM ".MAIN_DB_PREFIX."facturedet
                    GROUP BY fk_facture
                ) fl ON fl.fk_facture = f.rowid
                JOIN ".MAIN_DB_PREFIX."facturedet fd ON f.rowid = fd.fk_facture
                WHERE p.datep >= '".$date_debut."'
                AND p.datep < '".$date_fin_exclusive."'
                AND f.entity IN (".getEntity('invoice').")
                AND fl.total_ttc <> 0
                GROUP BY COALESCE(fd.product_type, 1)

                UNION ALL

                SELECT -1 AS product_type, SUM(pf.amount) AS total
                FROM ".MAIN_DB_PREFIX."paiement p
                JOIN ".MAIN_DB_PREFIX."paiement_facture pf ON p.rowid = pf.fk_paiement
                JOIN ".MAIN_DB_PREFIX."facture f ON pf.fk_facture = f.rowid
                LEFT JOIN (
                    SELECT fk_facture, SUM(total_ttc) AS total_ttc
                    FROM ".MAIN_DB_PREFIX."facturedet
                    GROUP BY fk_facture
                ) fl ON fl.fk_facture = f.rowid
                WHERE p.datep >= '".$date_debut."'
                AND p.datep < '".$date_fin_exclusive."'
                AND f.entity IN (".getEntity('invoice').")
                AND (fl.total_ttc IS NULL OR fl.total_ttc = 0)
            ) typed_totals
            WHERE typed_totals.total IS NOT NULL
            GROUP BY typed_totals.product_type";

    $sql_total_paiements = "SELECT SUM(pf.amount) AS total
            FROM ".MAIN_DB_PREFIX."paiement p
            JOIN ".MAIN_DB_PREFIX."paiement_facture pf ON p.rowid = pf.fk_paiement
            JOIN ".MAIN_DB_PREFIX."facture f ON pf.fk_facture = f.rowid
            WHERE p.datep >= '".$date_debut."'
            AND p.datep < '".$date_fin_exclusive."'
            AND f.entity IN (".getEntity('invoice').")";

    $sql_rapprochement = "SELECT p.ref AS paiement_ref,
                p.datep,
                f.ref AS facture_ref,
                pf.amount AS montant_reglement,
                COALESCE(fl.total_lignes, 0) AS total_lignes,
                f.total_ttc AS total_facture,
                COALESCE(v.total_ventile, 0) AS total_ventile,
                (pf.amount - COALESCE(v.total_ventile, 0)) AS ecart
            FROM ".MAIN_DB_PREFIX."paiement p
            JOIN ".MAIN_DB_PREFIX."paiement_facture pf ON p.rowid = pf.fk_paiement
            JOIN ".MAIN_DB_PREFIX."facture f ON pf.fk_facture = f.rowid
            LEFT JOIN (
                SELECT fk_facture, SUM(total_ttc) AS total_lignes
                FROM ".MAIN_DB_PREFIX."facturedet
                GROUP BY fk_facture
            ) fl ON fl.fk_facture = f.rowid
            LEFT JOIN (
                SELECT pf2.fk_paiement,
                    pf2.fk_facture,
                    SUM(CASE
                        WHEN fl2.total_lignes IS NULL OR fl2.total_lignes = 0 THEN 0
                        ELSE pf2.amount * fd2.total_ttc / fl2.total_lignes
                    END) AS total_ventile
                FROM ".MAIN_DB_PREFIX."paiement_facture pf2
                JOIN ".MAIN_DB_PREFIX."facturedet fd2 ON fd2.fk_facture = pf2.fk_facture
                JOIN (
                    SELECT fk_facture, SUM(total_ttc) AS total_lignes
                    FROM ".MAIN_DB_PREFIX."facturedet
                    GROUP BY fk_facture
                ) fl2 ON fl2.fk_facture = pf2.fk_facture
                GROUP BY pf2.fk_paiement, pf2.fk_facture
            ) v ON v.fk_paiement = p.rowid AND v.fk_facture = f.rowid
            WHERE p.datep >= '".$date_debut."'
            AND p.datep < '".$date_fin_exclusive."'
            AND f.entity IN (".getEntity('invoice').")
            HAVING ABS(ecart) > 0.005
            ORDER BY p.datep, p.ref";

    $sql_ecarts_factures = "SELECT p.ref AS paiement_ref,
                p.datep,
                f.ref AS facture_ref,
                pf.amount AS montant_reglement,
                COALESCE(fl.total_lignes, 0) AS total_lignes,
                f.total_ttc AS total_facture,
                (f.total_ttc - COALESCE(fl.total_lignes, 0)) AS ecart_facture
            FROM ".MAIN_DB_PREFIX."paiement p
            JOIN ".MAIN_DB_PREFIX."paiement_facture pf ON p.rowid = pf.fk_paiement
            JOIN ".MAIN_DB_PREFIX."facture f ON pf.fk_facture = f.rowid
            LEFT JOIN (
                SELECT fk_facture, SUM(total_ttc) AS total_lignes
                FROM ".MAIN_DB_PREFIX."facturedet
                GROUP BY fk_facture
            ) fl ON fl.fk_facture = f.rowid
            WHERE p.datep >= '".$date_debut."'
            AND p.datep < '".$date_fin_exclusive."'
            AND f.entity IN (".getEntity('invoice').")
            AND ABS(f.total_ttc - COALESCE(fl.total_lignes, 0)) > 0.005
            ORDER BY p.datep, p.ref";

    $resql = $db->query($sql);
    if (!$resql) {
        echo '<p>Erreur SQL : ' . $db->lasterror() . '</p>';
    } else {
        echo '<h3>Paramètres de calcul :</h3>';
        echo '<p><strong>Régime fiscal :</strong> ' . $regime_fiscal . '</p>';
        echo '<p><strong>Formation prof. obligatoire :</strong> ' . number_format($formation_prof, 2, ',', ' ') . ' %</p>';
        echo '<p><strong>Taxe CCI vente :</strong> ' . number_format($taxe_cci_vente, 2, ',', ' ') . ' %</p>';
        echo '<p><strong>Taxe CCI prestation :</strong> ' . number_format($taxe_cci_prestation, 2, ',', ' ') . ' %</p>';
        
        if($regime_fiscal == 'BIC') {
            echo '<p><em>Taxe CCI vente : appliquée uniquement sur les produits<br>';
            echo 'Taxe CCI prestation : appliquée uniquement sur les services</em></p>';
        } else {
            echo '<p><em>Les taxes CCI ne s\'appliquent pas en régime BNC</em></p>';
        }

		echo '<div class="info" style="margin: 15px 0;">';
		echo img_warning() . ' <strong>Information importante</strong> : Vous devez saisir dans votre déclaration URSSAF uniquement les montants affichés dans la colonne « Total CA à déclarer ». <br/>La colonne « Montant des charges » est une estimation indicative du montant des charges à payer.';
		echo '</div>';
        
        echo '<h3>Résultats :</h3>';

        $total_paiements = 0;
        $resql_total_paiements = $db->query($sql_total_paiements);
        if ($resql_total_paiements) {
            $obj_total_paiements = $db->fetch_object($resql_total_paiements);
            $total_paiements = (float) $obj_total_paiements->total;
        }

        echo '<table class="noborder">
                <tr class="liste_titre">
                    <th>Type</th>
                    <th>Total CA à déclarer</th>
                    <th>Montant des charges</th>
                </tr>';
        
        $total = 0;
        $total_ca = 0;
        $total_cci = 0;
        $total_non_ventile = 0;
        while ($obj = $db->fetch_object($resql)) {
			$ca_type = round((float) $obj->total, 2);
			$charges = 0;
			$charges_base = 0;
			$charges_formation = 0;
			$charges_cci = 0;
			
			if($obj->product_type == -1) {
				$total_non_ventile += $ca_type;
			} else {
				// Calcul des charges de base
				if($obj->product_type == 0) {
					// Produits : toujours 12.42%
					$charges_base = ($ca_type * 12.30) / 100;   
				} else {
					// Services : selon le régime fiscal
					if($regime_fiscal == 'BIC') {
						$charges_base = ($ca_type * 21.20) / 100;
					} else {
						$charges_base = ($ca_type * 24.60) / 100;
					}
				}
				
				// Formation professionnelle obligatoire (sur tout le CA)
				$charges_formation = ($ca_type * $formation_prof) / 100;
				
				// Charges brutes (base + formation) sans les frais consulaires
				$charges_brutes = $charges_base + $charges_formation;
				$charges_brutes = floor($charges_brutes * 100) / 100;
				
				// Taxes CCI (uniquement si BIC)
				if($regime_fiscal == 'BIC') {
					if($obj->product_type == 0) {
						// Taxe CCI vente : uniquement sur les produits (product_type == 0)
						$charges_cci += ($ca_type * $taxe_cci_vente) / 100;
					} else {
						// Taxe CCI prestation : uniquement sur les services (product_type !== 0)
						$charges_cci += ($ca_type * $taxe_cci_prestation) / 100;
					}
				}
				$charges_cci = floor($charges_cci * 100) / 100;
				
				// Total des charges (brutes + CCI)
				$charges = $charges_brutes + $charges_cci;
			}
			
			$total += $charges;
			$total_ca += $ca_type;
			$total_cci += $charges_cci;

			if($obj->product_type == -1) {
				$type_label = 'Non ventilé';
				$charges_label = 'À classer';
			} elseif($obj->product_type == 0) {
				$type_label = 'Produits';
				$charges_label = number_format($charges_brutes, 2, ',', ' ') .' €';
			} else {
				$type_label = 'Services';
				$charges_label = number_format($charges_brutes, 2, ',', ' ') .' €';
			}
			
            echo '<tr>
                    <td>' . $type_label . '</td>
                    <td>' . price($ca_type) . ' € </td>
                    <td>' . $charges_label . '</td>
                  </tr>';
        }

        if($total_non_ventile > 0) {
			echo '<tr>
					<td colspan="3" class="opacitymedium">' . img_warning() . ' ' . price($total_non_ventile) . ' € de règlements sont rattachés à des factures sans lignes ventilables. Vérifiez les factures concernées avant de déclarer les charges.</td>
				  </tr>';
		}

		$ecart_paiements = $total_paiements - $total_ca;
		if(abs($ecart_paiements) > 0.005) {
			echo '<tr>
					<td colspan="3" class="error">' . img_warning() . ' Le total ventilé ne correspond pas au total des règlements Dolibarr. Écart : ' . price($ecart_paiements) . ' €. Utilisez le total des règlements Dolibarr comme référence et vérifiez le rapprochement ci-dessous.</td>
				  </tr>';
		}
        
        // Ligne frais consulaires (uniquement si BIC)
        if($regime_fiscal == 'BIC') {
            echo '<tr>
                    <td>Frais chambre consulaire (CCI)</td>
                    <td></td>
                    <td>' . number_format($total_cci, 2, ',', ' ') .' €</td>
                  </tr>';
        }
        
        // Ligne de total général
        echo '<tr class="liste_total">
                <td><strong>Total général des charges à payer</strong><br><span class="opacitymedium">CA encaissé Dolibarr</span></td>
                <td><strong>' . price($total_paiements) . ' €</strong></td>
                <td><strong>' . number_format($total, 2, ',', ' ') .' €</strong></td>
              </tr>';
        
        echo '</table>';

		echo '<p><strong>Total règlements Dolibarr :</strong> ' . price($total_paiements) . ' €</p>';
		echo '<p><strong>Écart règlements / CA ventilé :</strong> ' . price($ecart_paiements) . ' €</p>';

		$resql_ecarts_factures = $db->query($sql_ecarts_factures);
		if($resql_ecarts_factures && $db->num_rows($resql_ecarts_factures) > 0) {
			echo '<h3>Factures avec écart entre total facture et lignes :</h3>';
			echo '<table class="noborder">
					<tr class="liste_titre">
						<th>Règlement</th>
						<th>Date</th>
						<th>Facture</th>
						<th>Montant réglé</th>
						<th>Total lignes facture</th>
						<th>Total facture</th>
						<th>Écart facture</th>
					</tr>';
			while($obj_ecart_facture = $db->fetch_object($resql_ecarts_factures)) {
				echo '<tr>
						<td>' . dol_escape_htmltag($obj_ecart_facture->paiement_ref) . '</td>
						<td>' . dol_print_date($db->jdate($obj_ecart_facture->datep), 'dayhour') . '</td>
						<td>' . dol_escape_htmltag($obj_ecart_facture->facture_ref) . '</td>
						<td>' . price($obj_ecart_facture->montant_reglement) . ' €</td>
						<td>' . price($obj_ecart_facture->total_lignes) . ' €</td>
						<td>' . price($obj_ecart_facture->total_facture) . ' €</td>
						<td>' . price($obj_ecart_facture->ecart_facture) . ' €</td>
					  </tr>';
			}
			echo '</table>';
		}

		if(abs($ecart_paiements) > 0.005) {
			$resql_rapprochement = $db->query($sql_rapprochement);
			if($resql_rapprochement) {
				echo '<h3>Rapprochement à vérifier :</h3>';
				echo '<table class="noborder">
						<tr class="liste_titre">
							<th>Règlement</th>
							<th>Date</th>
							<th>Facture</th>
							<th>Montant réglé</th>
							<th>Total lignes facture</th>
							<th>Total facture</th>
							<th>Montant ventilé</th>
							<th>Écart</th>
						</tr>';
				while($obj_rapprochement = $db->fetch_object($resql_rapprochement)) {
					echo '<tr>
							<td>' . dol_escape_htmltag($obj_rapprochement->paiement_ref) . '</td>
							<td>' . dol_print_date($db->jdate($obj_rapprochement->datep), 'dayhour') . '</td>
							<td>' . dol_escape_htmltag($obj_rapprochement->facture_ref) . '</td>
							<td>' . price($obj_rapprochement->montant_reglement) . ' €</td>
							<td>' . price($obj_rapprochement->total_lignes) . ' €</td>
							<td>' . price($obj_rapprochement->total_facture) . ' €</td>
							<td>' . price($obj_rapprochement->total_ventile) . ' €</td>
							<td>' . price($obj_rapprochement->ecart) . ' €</td>
						  </tr>';
				}
				echo '</table>';
			}
		}
		$total = floor($total * 100) / 100;
		$total_cci = floor($total_cci * 100) / 100;
		
		// echo '<br>';
		// echo '<p><strong>Total des charges (base + formation) : ' . number_format($total - $total_cci, 2, ',', ' ').' €</strong></p>';
		
		// if($regime_fiscal == 'BIC' && $total_cci > 0) {
		// 	echo '<p><strong>Total des taxes CCI : ' . number_format($total_cci, 2, ',', ' ').' €</strong></p>';
		// 	echo '<p><strong>Total général des charges à payer : ' . number_format($total, 2, ',', ' ').' €</strong></p>';
		// } else {
		// 	echo '<p><strong>Total des charges à payer pour cette période : ' . number_format($total, 2, ',', ' ').' €</strong></p>';
		// }
    }
}

llxFooter();
$db->close();
?>
