<?php
interface Command { public function execute(): void; public function undo(): void; }
class StudentSystem {
    public function enroll(): void { echo "Student successfully enrolled.\n"; }
    public function drop(): void { echo "Subject successfully dropped.\n"; }
    public function printRegistration(): void { echo "Registration printed.\n"; }
    public function logout(): void { echo "Student logged out.\n"; }
}
class EnrollCommand implements Command {
    public function __construct(private StudentSystem $system) {}
    public function execute(): void { $this->system->enroll(); }
    public function undo(): void { echo "Enrollment undone.\n"; }
}
class DropSubjectCommand implements Command {
    public function __construct(private StudentSystem $system) {}
    public function execute(): void { $this->system->drop(); }
    public function undo(): void { echo "Drop subject undone.\n"; }
}
class PrintRegistrationCommand implements Command {
    public function __construct(private StudentSystem $system) {}
    public function execute(): void { $this->system->printRegistration(); }
    public function undo(): void { echo "Printing cannot be undone.\n"; }
}
class LogoutCommand implements Command {
    public function __construct(private StudentSystem $system) {}
    public function execute(): void { $this->system->logout(); }
    public function undo(): void { echo "Logout cannot be undone.\n"; }
}
class Invoker {
    private array $history = [];
    public function run(string $name, Command $command): void {
        echo "Executing: $name\n";
        $command->execute(); $this->history[] = $command;
    }
    public function undo(): void { $command = array_pop($this->history); if ($command) $command->undo(); }
}
$system = new StudentSystem(); $invoker = new Invoker();
$invoker->run('Enroll Student', new EnrollCommand($system));
$invoker->run('Drop Subject', new DropSubjectCommand($system));
$invoker->undo();
$invoker->run('Print Registration', new PrintRegistrationCommand($system));
$invoker->run('Logout', new LogoutCommand($system));
