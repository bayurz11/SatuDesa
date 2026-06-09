<?php

namespace App\Livewire\Admin\Budgets;

use App\Domains\Budget\Models\ApbdesBankBookEntry;
use App\Domains\Budget\Models\ApbdesBudgetLine;
use App\Domains\Budget\Models\ApbdesCashBookEntry;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesPaymentRequest;
use App\Domains\Budget\Models\ApbdesRealization;
use App\Domains\Budget\Models\ApbdesTaxBookEntry;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Component;

class OperationsBoard extends Component
{
    use WithAlerts;

    public bool $showPaymentModal = false;
    public bool $showRealizationModal = false;
    public bool $showCashBookModal = false;
    public bool $showBankBookModal = false;
    public bool $showTaxBookModal = false;

    public ?int $paymentRequestId = null;
    public string $payment_fiscal_year_id = '';
    public string $payment_budget_line_id = '';
    public string $request_number = '';
    public string $request_date = '';
    public string $payee_name = '';
    public string $payment_amount = '0';
    public string $payment_status = 'draft';
    public string $payment_description = '';

    public ?int $realizationId = null;
    public string $realization_fiscal_year_id = '';
    public string $realization_budget_line_id = '';
    public string $realization_payment_request_id = '';
    public string $transaction_date = '';
    public string $reference_number = '';
    public string $payment_method = 'cash';
    public string $realization_amount = '0';
    public string $realization_status = 'posted';
    public string $realization_description = '';

    public ?int $cashBookId = null;
    public string $cash_fiscal_year_id = '';
    public string $cash_realization_id = '';
    public string $cash_entry_date = '';
    public string $cash_reference_number = '';
    public string $cash_description = '';
    public string $cash_debit_amount = '0';
    public string $cash_credit_amount = '0';
    public string $cash_balance = '0';

    public ?int $bankBookId = null;
    public string $bank_fiscal_year_id = '';
    public string $bank_realization_id = '';
    public string $bank_entry_date = '';
    public string $bank_reference_number = '';
    public string $bank_name = '';
    public string $bank_description = '';
    public string $bank_debit_amount = '0';
    public string $bank_credit_amount = '0';
    public string $bank_balance = '0';

    public ?int $taxBookId = null;
    public string $tax_fiscal_year_id = '';
    public string $tax_realization_id = '';
    public string $tax_entry_date = '';
    public string $tax_reference_number = '';
    public string $tax_type = '';
    public string $tax_description = '';
    public string $tax_base_amount = '0';
    public string $withheld_amount = '0';
    public string $remitted_amount = '0';
    public string $tax_status = 'withheld';

    protected function paymentRules(): array
    {
        return [
            'payment_fiscal_year_id' => ['required', 'exists:apbdes_fiscal_years,id'],
            'payment_budget_line_id' => ['nullable', 'exists:apbdes_budget_lines,id'],
            'request_number' => ['required', 'string', 'max:255', 'unique:apbdes_payment_requests,request_number,' . $this->paymentRequestId],
            'request_date' => ['required', 'date'],
            'payee_name' => ['required', 'string', 'max:255'],
            'payment_amount' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:draft,submitted,approved,rejected,paid'],
            'payment_description' => ['nullable', 'string'],
        ];
    }

    protected function realizationRules(): array
    {
        return [
            'realization_fiscal_year_id' => ['required', 'exists:apbdes_fiscal_years,id'],
            'realization_budget_line_id' => ['required', 'exists:apbdes_budget_lines,id'],
            'realization_payment_request_id' => ['nullable', 'exists:apbdes_payment_requests,id'],
            'transaction_date' => ['required', 'date'],
            'reference_number' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'in:cash,bank,transfer'],
            'realization_amount' => ['required', 'numeric', 'min:0'],
            'realization_status' => ['required', 'in:draft,posted,verified'],
            'realization_description' => ['nullable', 'string'],
        ];
    }

    protected function cashBookRules(): array
    {
        return [
            'cash_fiscal_year_id' => ['required', 'exists:apbdes_fiscal_years,id'],
            'cash_realization_id' => ['nullable', 'exists:apbdes_realizations,id'],
            'cash_entry_date' => ['required', 'date'],
            'cash_reference_number' => ['required', 'string', 'max:255'],
            'cash_description' => ['required', 'string', 'max:255'],
            'cash_debit_amount' => ['required', 'numeric', 'min:0'],
            'cash_credit_amount' => ['required', 'numeric', 'min:0'],
            'cash_balance' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function bankBookRules(): array
    {
        return [
            'bank_fiscal_year_id' => ['required', 'exists:apbdes_fiscal_years,id'],
            'bank_realization_id' => ['nullable', 'exists:apbdes_realizations,id'],
            'bank_entry_date' => ['required', 'date'],
            'bank_reference_number' => ['required', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_description' => ['required', 'string', 'max:255'],
            'bank_debit_amount' => ['required', 'numeric', 'min:0'],
            'bank_credit_amount' => ['required', 'numeric', 'min:0'],
            'bank_balance' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function taxBookRules(): array
    {
        return [
            'tax_fiscal_year_id' => ['required', 'exists:apbdes_fiscal_years,id'],
            'tax_realization_id' => ['nullable', 'exists:apbdes_realizations,id'],
            'tax_entry_date' => ['required', 'date'],
            'tax_reference_number' => ['required', 'string', 'max:255'],
            'tax_type' => ['required', 'string', 'max:255'],
            'tax_description' => ['required', 'string', 'max:255'],
            'tax_base_amount' => ['required', 'numeric', 'min:0'],
            'withheld_amount' => ['required', 'numeric', 'min:0'],
            'remitted_amount' => ['required', 'numeric', 'min:0'],
            'tax_status' => ['required', 'in:withheld,remitted'],
        ];
    }

    public function savePaymentRequest(): void
    {
        $validated = $this->validate($this->paymentRules());

        $record = ApbdesPaymentRequest::updateOrCreate(
            ['id' => $this->paymentRequestId],
            [
                'fiscal_year_id' => $validated['payment_fiscal_year_id'],
                'budget_line_id' => $validated['payment_budget_line_id'] ?: null,
                'request_number' => $validated['request_number'],
                'request_date' => $validated['request_date'],
                'payee_name' => $validated['payee_name'],
                'amount' => $validated['payment_amount'],
                'status' => $validated['payment_status'],
                'description' => $validated['payment_description'] ?: null,
            ]
        );

        LoggerService::logUserAction($this->paymentRequestId ? 'update' : 'create', 'ApbdesPaymentRequest', $record->id, ['request_number' => $record->request_number]);
        $this->showSuccessToast('Data SPP berhasil disimpan.');
        $this->showPaymentModal = false;
        $this->resetPaymentRequestForm();
    }

    public function openPaymentModal(?int $id = null): void
    {
        if ($id) {
            $this->editPaymentRequest($id);
        } else {
            $this->resetPaymentRequestForm();
        }

        $this->showPaymentModal = true;
    }

    public function closePaymentModal(): void
    {
        $this->showPaymentModal = false;
    }

    public function editPaymentRequest(int $id): void
    {
        $record = ApbdesPaymentRequest::findOrFail($id);
        $this->paymentRequestId = $record->id;
        $this->payment_fiscal_year_id = (string) $record->fiscal_year_id;
        $this->payment_budget_line_id = (string) ($record->budget_line_id ?? '');
        $this->request_number = $record->request_number;
        $this->request_date = optional($record->request_date)->format('Y-m-d') ?? '';
        $this->payee_name = $record->payee_name;
        $this->payment_amount = (string) $record->amount;
        $this->payment_status = $record->status;
        $this->payment_description = $record->description ?? '';
    }

    public function confirmDeletePaymentRequest(int $id): void
    {
        $record = ApbdesPaymentRequest::findOrFail($id);
        $this->showConfirm('Hapus SPP', "Hapus SPP {$record->request_number}?", 'deletePaymentRequest', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function deletePaymentRequest(array $params): void
    {
        ApbdesPaymentRequest::findOrFail($params['id'])->delete();
        $this->showSuccessToast('SPP berhasil dihapus.');
    }

    public function resetPaymentRequestForm(): void
    {
        $this->reset(['paymentRequestId', 'payment_fiscal_year_id', 'payment_budget_line_id', 'request_number', 'request_date', 'payee_name', 'payment_description']);
        $this->payment_amount = '0';
        $this->payment_status = 'draft';
        $this->resetErrorBag();
    }

    public function saveRealization(): void
    {
        $validated = $this->validate($this->realizationRules());

        $record = ApbdesRealization::updateOrCreate(
            ['id' => $this->realizationId],
            [
                'fiscal_year_id' => $validated['realization_fiscal_year_id'],
                'budget_line_id' => $validated['realization_budget_line_id'],
                'payment_request_id' => $validated['realization_payment_request_id'] ?: null,
                'transaction_date' => $validated['transaction_date'],
                'reference_number' => $validated['reference_number'],
                'payment_method' => $validated['payment_method'],
                'amount' => $validated['realization_amount'],
                'status' => $validated['realization_status'],
                'description' => $validated['realization_description'] ?: null,
            ]
        );

        $this->syncBudgetLineRealization((int) $validated['realization_budget_line_id']);
        LoggerService::logUserAction($this->realizationId ? 'update' : 'create', 'ApbdesRealization', $record->id, ['reference_number' => $record->reference_number]);
        $this->showSuccessToast('Data realisasi berhasil disimpan.');
        $this->showRealizationModal = false;
        $this->resetRealizationForm();
    }

    public function openRealizationModal(?int $id = null): void
    {
        if ($id) {
            $this->editRealization($id);
        } else {
            $this->resetRealizationForm();
        }

        $this->showRealizationModal = true;
    }

    public function closeRealizationModal(): void
    {
        $this->showRealizationModal = false;
    }

    public function editRealization(int $id): void
    {
        $record = ApbdesRealization::findOrFail($id);
        $this->realizationId = $record->id;
        $this->realization_fiscal_year_id = (string) $record->fiscal_year_id;
        $this->realization_budget_line_id = (string) $record->budget_line_id;
        $this->realization_payment_request_id = (string) ($record->payment_request_id ?? '');
        $this->transaction_date = optional($record->transaction_date)->format('Y-m-d') ?? '';
        $this->reference_number = $record->reference_number;
        $this->payment_method = $record->payment_method;
        $this->realization_amount = (string) $record->amount;
        $this->realization_status = $record->status;
        $this->realization_description = $record->description ?? '';
    }

    public function confirmDeleteRealization(int $id): void
    {
        $record = ApbdesRealization::findOrFail($id);
        $this->showConfirm('Hapus Realisasi', "Hapus realisasi {$record->reference_number}?", 'deleteRealization', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function deleteRealization(array $params): void
    {
        $record = ApbdesRealization::findOrFail($params['id']);
        $budgetLineId = $record->budget_line_id;
        $record->delete();
        $this->syncBudgetLineRealization($budgetLineId);
        $this->showSuccessToast('Realisasi berhasil dihapus.');
    }

    public function resetRealizationForm(): void
    {
        $this->reset(['realizationId', 'realization_fiscal_year_id', 'realization_budget_line_id', 'realization_payment_request_id', 'transaction_date', 'reference_number', 'realization_description']);
        $this->payment_method = 'cash';
        $this->realization_amount = '0';
        $this->realization_status = 'posted';
        $this->resetErrorBag();
    }

    public function saveCashBook(): void
    {
        $validated = $this->validate($this->cashBookRules());

        ApbdesCashBookEntry::updateOrCreate(
            ['id' => $this->cashBookId],
            [
                'fiscal_year_id' => $validated['cash_fiscal_year_id'],
                'realization_id' => $validated['cash_realization_id'] ?: null,
                'entry_date' => $validated['cash_entry_date'],
                'reference_number' => $validated['cash_reference_number'],
                'description' => $validated['cash_description'],
                'debit_amount' => $validated['cash_debit_amount'],
                'credit_amount' => $validated['cash_credit_amount'],
                'balance' => $validated['cash_balance'],
            ]
        );

        $this->showSuccessToast('Buku kas berhasil disimpan.');
        $this->showCashBookModal = false;
        $this->resetCashBookForm();
    }

    public function openCashBookModal(?int $id = null): void
    {
        if ($id) {
            $this->editCashBook($id);
        } else {
            $this->resetCashBookForm();
        }

        $this->showCashBookModal = true;
    }

    public function closeCashBookModal(): void
    {
        $this->showCashBookModal = false;
    }

    public function editCashBook(int $id): void
    {
        $record = ApbdesCashBookEntry::findOrFail($id);
        $this->cashBookId = $record->id;
        $this->cash_fiscal_year_id = (string) $record->fiscal_year_id;
        $this->cash_realization_id = (string) ($record->realization_id ?? '');
        $this->cash_entry_date = optional($record->entry_date)->format('Y-m-d') ?? '';
        $this->cash_reference_number = $record->reference_number;
        $this->cash_description = $record->description;
        $this->cash_debit_amount = (string) $record->debit_amount;
        $this->cash_credit_amount = (string) $record->credit_amount;
        $this->cash_balance = (string) $record->balance;
    }

    public function confirmDeleteCashBook(int $id): void
    {
        $this->showConfirm('Hapus Buku Kas', 'Hapus entri buku kas ini?', 'deleteCashBook', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function deleteCashBook(array $params): void
    {
        ApbdesCashBookEntry::findOrFail($params['id'])->delete();
        $this->showSuccessToast('Entri buku kas berhasil dihapus.');
    }

    public function resetCashBookForm(): void
    {
        $this->reset(['cashBookId', 'cash_fiscal_year_id', 'cash_realization_id', 'cash_entry_date', 'cash_reference_number', 'cash_description']);
        $this->cash_debit_amount = '0';
        $this->cash_credit_amount = '0';
        $this->cash_balance = '0';
        $this->resetErrorBag();
    }

    public function saveBankBook(): void
    {
        $validated = $this->validate($this->bankBookRules());

        ApbdesBankBookEntry::updateOrCreate(
            ['id' => $this->bankBookId],
            [
                'fiscal_year_id' => $validated['bank_fiscal_year_id'],
                'realization_id' => $validated['bank_realization_id'] ?: null,
                'entry_date' => $validated['bank_entry_date'],
                'reference_number' => $validated['bank_reference_number'],
                'bank_name' => $validated['bank_name'] ?: null,
                'description' => $validated['bank_description'],
                'debit_amount' => $validated['bank_debit_amount'],
                'credit_amount' => $validated['bank_credit_amount'],
                'balance' => $validated['bank_balance'],
            ]
        );

        $this->showSuccessToast('Buku bank berhasil disimpan.');
        $this->showBankBookModal = false;
        $this->resetBankBookForm();
    }

    public function openBankBookModal(?int $id = null): void
    {
        if ($id) {
            $this->editBankBook($id);
        } else {
            $this->resetBankBookForm();
        }

        $this->showBankBookModal = true;
    }

    public function closeBankBookModal(): void
    {
        $this->showBankBookModal = false;
    }

    public function editBankBook(int $id): void
    {
        $record = ApbdesBankBookEntry::findOrFail($id);
        $this->bankBookId = $record->id;
        $this->bank_fiscal_year_id = (string) $record->fiscal_year_id;
        $this->bank_realization_id = (string) ($record->realization_id ?? '');
        $this->bank_entry_date = optional($record->entry_date)->format('Y-m-d') ?? '';
        $this->bank_reference_number = $record->reference_number;
        $this->bank_name = $record->bank_name ?? '';
        $this->bank_description = $record->description;
        $this->bank_debit_amount = (string) $record->debit_amount;
        $this->bank_credit_amount = (string) $record->credit_amount;
        $this->bank_balance = (string) $record->balance;
    }

    public function confirmDeleteBankBook(int $id): void
    {
        $this->showConfirm('Hapus Buku Bank', 'Hapus entri buku bank ini?', 'deleteBankBook', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function deleteBankBook(array $params): void
    {
        ApbdesBankBookEntry::findOrFail($params['id'])->delete();
        $this->showSuccessToast('Entri buku bank berhasil dihapus.');
    }

    public function resetBankBookForm(): void
    {
        $this->reset(['bankBookId', 'bank_fiscal_year_id', 'bank_realization_id', 'bank_entry_date', 'bank_reference_number', 'bank_name', 'bank_description']);
        $this->bank_debit_amount = '0';
        $this->bank_credit_amount = '0';
        $this->bank_balance = '0';
        $this->resetErrorBag();
    }

    public function saveTaxBook(): void
    {
        $validated = $this->validate($this->taxBookRules());

        ApbdesTaxBookEntry::updateOrCreate(
            ['id' => $this->taxBookId],
            [
                'fiscal_year_id' => $validated['tax_fiscal_year_id'],
                'realization_id' => $validated['tax_realization_id'] ?: null,
                'entry_date' => $validated['tax_entry_date'],
                'reference_number' => $validated['tax_reference_number'],
                'tax_type' => $validated['tax_type'],
                'description' => $validated['tax_description'],
                'tax_base_amount' => $validated['tax_base_amount'],
                'withheld_amount' => $validated['withheld_amount'],
                'remitted_amount' => $validated['remitted_amount'],
                'status' => $validated['tax_status'],
            ]
        );

        $this->showSuccessToast('Buku pajak berhasil disimpan.');
        $this->showTaxBookModal = false;
        $this->resetTaxBookForm();
    }

    public function openTaxBookModal(?int $id = null): void
    {
        if ($id) {
            $this->editTaxBook($id);
        } else {
            $this->resetTaxBookForm();
        }

        $this->showTaxBookModal = true;
    }

    public function closeTaxBookModal(): void
    {
        $this->showTaxBookModal = false;
    }

    public function editTaxBook(int $id): void
    {
        $record = ApbdesTaxBookEntry::findOrFail($id);
        $this->taxBookId = $record->id;
        $this->tax_fiscal_year_id = (string) $record->fiscal_year_id;
        $this->tax_realization_id = (string) ($record->realization_id ?? '');
        $this->tax_entry_date = optional($record->entry_date)->format('Y-m-d') ?? '';
        $this->tax_reference_number = $record->reference_number;
        $this->tax_type = $record->tax_type;
        $this->tax_description = $record->description;
        $this->tax_base_amount = (string) $record->tax_base_amount;
        $this->withheld_amount = (string) $record->withheld_amount;
        $this->remitted_amount = (string) $record->remitted_amount;
        $this->tax_status = $record->status;
    }

    public function confirmDeleteTaxBook(int $id): void
    {
        $this->showConfirm('Hapus Buku Pajak', 'Hapus entri buku pajak ini?', 'deleteTaxBook', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function deleteTaxBook(array $params): void
    {
        ApbdesTaxBookEntry::findOrFail($params['id'])->delete();
        $this->showSuccessToast('Entri buku pajak berhasil dihapus.');
    }

    public function resetTaxBookForm(): void
    {
        $this->reset(['taxBookId', 'tax_fiscal_year_id', 'tax_realization_id', 'tax_entry_date', 'tax_reference_number', 'tax_type', 'tax_description']);
        $this->tax_base_amount = '0';
        $this->withheld_amount = '0';
        $this->remitted_amount = '0';
        $this->tax_status = 'withheld';
        $this->resetErrorBag();
    }

    protected function syncBudgetLineRealization(int $budgetLineId): void
    {
        $totalRealization = ApbdesRealization::query()
            ->where('budget_line_id', $budgetLineId)
            ->sum('amount');

        ApbdesBudgetLine::query()
            ->whereKey($budgetLineId)
            ->update(['realized_amount' => $totalRealization]);
    }

    public function render()
    {
        $fiscalYears = ApbdesFiscalYear::query()->orderByDesc('year')->get(['id', 'title']);
        $budgetLines = ApbdesBudgetLine::query()->with(['account:id,code,name', 'fiscalYear:id,title'])->orderByDesc('updated_at')->get(['id', 'fiscal_year_id', 'account_id', 'description']);
        $paymentRequests = ApbdesPaymentRequest::query()->with(['fiscalYear:id,title', 'budgetLine:id,description'])->latest('request_date')->limit(10)->get();
        $realizations = ApbdesRealization::query()->with(['fiscalYear:id,title', 'budgetLine:id,description'])->latest('transaction_date')->limit(10)->get();
        $cashBooks = ApbdesCashBookEntry::query()->with('fiscalYear:id,title')->latest('entry_date')->limit(10)->get();
        $bankBooks = ApbdesBankBookEntry::query()->with('fiscalYear:id,title')->latest('entry_date')->limit(10)->get();
        $taxBooks = ApbdesTaxBookEntry::query()->with('fiscalYear:id,title')->latest('entry_date')->limit(10)->get();

        $stats = [
            'payment_requests' => ApbdesPaymentRequest::query()->count(),
            'realizations' => ApbdesRealization::query()->count(),
            'cash_books' => ApbdesCashBookEntry::query()->count(),
            'bank_books' => ApbdesBankBookEntry::query()->count(),
            'tax_books' => ApbdesTaxBookEntry::query()->count(),
        ];

        return view('livewire.admin.budgets.operations-board', compact(
            'fiscalYears',
            'budgetLines',
            'paymentRequests',
            'realizations',
            'cashBooks',
            'bankBooks',
            'taxBooks',
            'stats',
        ));
    }
}
