<?php
abstract class Handler {
    protected ?Handler $next = null;
    public function setNext(Handler $handler): Handler { $this->next = $handler; return $handler; }
    public function handle(string $request): void {
        if ($this->canHandle($request)) { echo $this->office() . ": Processing $request...\n"; return; }
        echo $this->office() . ": Cannot process request.\n";
        if ($this->next) $this->next->handle($request);
        else echo "No office can process this request.\n";
    }
    abstract protected function office(): string;
    abstract protected function canHandle(string $request): bool;
}
class StudentAffairsHandler extends Handler {
    protected function office(): string { return 'Student Affairs'; }
    protected function canHandle(string $request): bool { return $request === 'Good Moral Certificate'; }
}
class RegistrarHandler extends Handler {
    protected function office(): string { return 'Registrar'; }
    protected function canHandle(string $request): bool { return in_array($request, ['Transcript of Records','Certificate of Enrollment'], true); }
}
class FinanceHandler extends Handler {
    protected function office(): string { return 'Finance'; }
    protected function canHandle(string $request): bool { return $request === 'Payment Concern'; }
}
class ICTHandler extends Handler {
    protected function office(): string { return 'ICT'; }
    protected function canHandle(string $request): bool { return $request === 'Student ID Concern'; }
}
class StudentRequest {
    public function __construct(public string $type) {}
}
$affairs = new StudentAffairsHandler();
$registrar = new RegistrarHandler();
$finance = new FinanceHandler();
$ict = new ICTHandler();
$affairs->setNext($registrar)->setNext($finance)->setNext($ict);
$request = new StudentRequest('Transcript of Records');
echo "Request: {$request->type}\n";
$affairs->handle($request->type);
