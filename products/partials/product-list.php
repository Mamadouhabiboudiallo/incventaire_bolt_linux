<?php
    echo "LES PRODUITS RECENTES";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "LES PRODUITS RECENTES";

    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['barcode']) . "</td>";
    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
    echo "<td class='d-flex gap-2'>";
    echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-sm btn-secondary'>Edit</a>";
    echo "<form method='POST' action='handlers/delete-handler.php' class='d-inline'>";
    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
    echo "<button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</button>";
    echo "</form>";
    echo "</td>";
    echo "</>";
}