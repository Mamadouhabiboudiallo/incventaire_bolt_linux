<?php
require_once '../includes/header.php';
require_once '../config/Database.php';
require_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Lire tous les produits
$stmt = $product->read();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculer le coût total de l'inventaire
$totalCost = 0;
$totalInventoryCost = 0;
$totalLoanCost = 0;
$totalAdditionalCosts = 0;
$totalGlobalCost = 0;
$totalPotentialRevenue = 0;
$totalGainOrLoss = 0;
$potentialRevenue = 0 ;
$globalCost = 0;

foreach ($products as $prod) {
    // Récupération des valeurs de chaque produit
    $purchasePrice = $prod['purchase_price'] ?? 0; // Prix d'achat unitaire
    $quantity = $prod['quantity'] ?? 0; // Quantité
    $price = $prod['price'] ?? 0; // Prix de vente unitaire
    $loans = $prod['loans'] ?? 0; // Prêts associés
    $additionalCosts = $prod['additional_costs'] ?? 0; // Autres coûts

    // Calculs
    $inventoryCost = $quantity * $purchasePrice; // Coût de l'inventaire
    $globalCost = $inventoryCost + $loans + $additionalCosts; // Coût global
    $potentialRevenue = $quantity * $price; // Recettes potentielles
    $gainOrLoss = $potentialRevenue - $globalCost; // Gain ou perte

    // Accumuler les totaux
    $totalInventoryCost =$totalInventoryCost + $inventoryCost;
    $totalLoanCost += $loans;
    $totalAdditionalCosts += $additionalCosts;
    $totalGlobalCost += $globalCost;
    $totalPotentialRevenue += $potentialRevenue;
    $totalGainOrLoss += $gainOrLoss;  
    $totalCost += $prod['quantity'] * $prod['price'];

}
    ?>

<div class="container">
    <h1>Gestion de l'Inventaire</h1>

    <form action="handlers/add-product.php" method="POST" class="mb-4">
        <div class="form-group">
            <label for="name">Nom du produit :</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantité :</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Prix de vente :</label>
            <input type="number" name="price" id="price" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="purchase_price">Prix d'achat :</label>
            <input type="number" name="purchase_price" id="purchase_price" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="additional_costs">Autres coûts :</label>
            <input type="number" name="additional_costs" id="additional_costs" step="0.01" class="form-control">
        </div>
        <div class="form-group">
            <label for="loans">Prêts :</label>
            <input type="number" name="loans" id="loans" step="0.01" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Ajouter le produit</button>
    </form>


    <table class="table table-striped">
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix de Vente</th>
                <th>Prix d'Achat</th>
                <th>Autres Coûts</th>
                <th>Prêts</th>
                <th>Coût Total</th>
                <th>Dernière Mise à Jour</th>
                <th>Gain ou Perte</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $prod): ?>
                <tr>
                    <td><?php echo htmlspecialchars($prod['name']); ?></td>
                    <td><?php echo htmlspecialchars($prod['quantity']); ?></td>
                    <td><?php echo number_format($prod['price'], 2, ',', ' ') . ' CFA'; ?></td>
                    <td><?php echo number_format($prod['purchase_price'], 2, ',', ' ') . ' CFA'; ?></td>
                    <td><?php echo number_format($prod['additional_costs'], 2, ',', ' ') . ' CFA'; ?></td>
                    <td><?php echo number_format($prod['loans'], 2, ',', ' ') . ' CFA'; ?></td>
                    <td>
                        <?php
                        $totalCost = ($prod['quantity'] * $prod['purchase_price']) + $prod['additional_costs'] + $prod['loans'];
                        echo number_format($totalCost, 2, ',', ' ') . ' CFA';
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($prod['updated_at']); ?></td>
                    <td>
                        <?php
                        $productGainOrLoss = $potentialRevenue - $globalCost;
                        $productGainLossClass = $productGainOrLoss >= 0 ? 'text-success' : 'text-danger';
                        echo "<span class='{$productGainLossClass}'>" . number_format($productGainOrLoss, 2, ',', ' ') . " CFA</span>";
                        ?>
                    </td>

                    <?php
                        echo "<td class='d-flex gap-2'>";
                        echo "<a href='../products/edit.php?id=" . ($prod['id'] ?? '') . "' class='btn btn-sm btn-secondary'>Edit</a>";
                        echo "<form method='POST' action='handlers/delete-handler.php' class='d-inline'>";
                        echo "<input type='hidden' name='id' value='" . ($prod['id'] ?? '') . "'>";
                        echo "<button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        ?>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

<div class="card mt-4">
    <div class="card-body">
        <h3>Résumé de l'Inventaire</h3>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Coût de l'Inventaire (Prix d'Achat x Quantité)</th>
                    <td><?php echo number_format($totalInventoryCost, 2, ',', ' ') . ' CFA'; ?></td>
                </tr>
                <tr>
                    <th>Coût Global des Prêts</th>
                    <td><?php echo number_format($totalLoanCost, 2, ',', ' ') . ' CFA'; ?></td>
                </tr>
                <tr>
                    <th>Autres Coûts (Transport, Taxes, etc.)</th>
                    <td><?php echo number_format($totalAdditionalCosts, 2, ',', ' ') . ' CFA'; ?></td>
                </tr>
                <tr>
                    <th>Coût Global Total (Inventaire + Prêts + Autres Coûts)</th>
                    <td><?php echo number_format($totalGlobalCost, 2, ',', ' ') . ' CFA'; ?></td>
                </tr>
                <tr>
                    <th>Recettes Potentielles (Prix de Vente x Quantité)</th>
                    <td><?php echo number_format($totalPotentialRevenue, 2, ',', ' ') . ' CFA'; ?></td>
                </tr>
                <tr>
                    <th>Gain ou Perte Total</th>
                    <td>
                        <?php
                        $gainLossClass = $totalGainOrLoss >= 0 ? 'text-success' : 'text-danger';
                        echo "<span class='{$gainLossClass}'>" . number_format($totalGainOrLoss, 2, ',', ' ') . " CFA</span>";
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    <div class="mt-3">
        <a href="generate-report.php" class="btn btn-primary">Imprimer le Rapport</a>
        <a href="../index.php" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
