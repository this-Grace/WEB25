<?php

/**
 * Partial per tabelle amministrative
 * 
 * Template params richiesti:
 * - tableTitle: Titolo della tabella
 * - tableData: Array di dati da visualizzare
 * - tableColumns: Array di colonne con configurazione
 *   Esempio: ['field' => 'id', 'label' => 'ID', 'class' => 'fw-bold']
 * - tableActions: Array di azioni disponibili (optional)
 * - searchPlaceholder: Testo placeholder ricerca (optional)
 * - statusFilter: Array di opzioni filtro stato (optional)
 */

$tableTitle = $templateParams['tableTitle'] ?? 'Dati';
$tableData = $templateParams['tableData'] ?? [];
$tableColumns = $templateParams['tableColumns'] ?? [];
$tableActions = $templateParams['tableActions'] ?? null;
$searchPlaceholder = $templateParams['searchPlaceholder'] ?? 'Cerca...';
$statusFilter = $templateParams['statusFilter'] ?? null;
$currentStatus = $_GET['status'] ?? '';
$searchTerm = $_GET['search'] ?? '';
$emptyMessage = $templateParams['emptyMessage'] ?? 'Nessun dato disponibile';
?>

<div class="card shadow-sm">
    <div class="card-header bg-body border-0 d-flex align-items-center justify-content-between">
        <h2 class="h6 mb-0"><?php echo htmlspecialchars($tableTitle); ?> (<?php echo count($tableData); ?>)</h2>
        <form method="GET" class="d-flex gap-2">
            <input type="search" name="search" class="form-control form-control-sm"
                placeholder="<?php echo htmlspecialchars($searchPlaceholder); ?>"
                style="max-width: 250px;"
                value="<?php echo htmlspecialchars($searchTerm); ?>">
            <?php if ($statusFilter): ?>
                <select name="status" class="form-select form-select-sm" style="max-width: 150px;" onchange="this.form.submit()">
                    <option value="">Tutti gli stati</option>
                    <?php foreach ($statusFilter as $value => $label): ?>
                        <option value="<?php echo htmlspecialchars($value); ?>"
                            <?php echo $currentStatus === $value ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead>
                    <tr>
                        <?php foreach ($tableColumns as $column): ?>
                            <th scope="col" class="<?php echo $column['headerClass'] ?? ''; ?>">
                                <?php echo htmlspecialchars($column['label']); ?>
                            </th>
                        <?php endforeach; ?>
                        <?php if ($tableActions): ?>
                            <th scope="col" class="text-end">Azioni</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tableData)): ?>
                        <tr>
                            <td colspan="<?php echo count($tableColumns) + ($tableActions ? 1 : 0); ?>"
                                class="text-center py-4 text-muted">
                                <?php echo htmlspecialchars($emptyMessage); ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tableData as $row): ?>
                            <tr>
                                <?php foreach ($tableColumns as $column): ?>
                                    <td class="<?php echo $column['class'] ?? ''; ?>">
                                        <?php
                                        $value = $row[$column['field']] ?? '';

                                        // Gestione tipo di campo
                                        if (isset($column['type'])):
                                            switch ($column['type']):
                                                case 'badge':
                                                    $badgeClass = $column['badgeClass'][$value] ?? 'secondary';
                                                    $badgeLabel = $column['badgeLabel'][$value] ?? $value;
                                                    echo '<span class="badge bg-' . htmlspecialchars($badgeClass) . '-subtle text-' . htmlspecialchars($badgeClass) . '">' . htmlspecialchars($badgeLabel) . '</span>';
                                                    break;
                                                case 'truncate':
                                                    $maxWidth = $column['maxWidth'] ?? '300px';
                                                    echo '<div class="text-truncate" style="max-width: ' . htmlspecialchars($maxWidth) . ';">' . htmlspecialchars($value) . '</div>';
                                                    break;
                                                case 'icon':
                                                    $icon = $column['icon'] ?? 'bi-heart-fill';
                                                    $iconClass = $column['iconClass'] ?? 'text-primary';
                                                    echo '<span class="bi ' . htmlspecialchars($icon) . ' ' . htmlspecialchars($iconClass) . ' me-1" aria-hidden="true"></span>' . htmlspecialchars($value);
                                                    break;
                                                case 'custom':
                                                    if (isset($column['render']) && is_callable($column['render'])):
                                                        echo $column['render']($row, $value);
                                                    else:
                                                        echo htmlspecialchars($value);
                                                    endif;
                                                    break;
                                                default:
                                                    echo htmlspecialchars($value);
                                            endswitch;
                                        else:
                                            echo htmlspecialchars($value);
                                        endif;
                                        ?>
                                    </td>
                                <?php endforeach; ?>

                                <?php if ($tableActions): ?>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <?php
                                            if (is_callable($tableActions)):
                                                echo $tableActions($row);
                                            endif;
                                            ?>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>