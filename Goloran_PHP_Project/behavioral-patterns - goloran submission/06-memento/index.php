<?php
class StudentProfileMemento {
    public function __construct(private array $state) {}
    public function getState(): array { return $this->state; }
}
class StudentProfile {
    public function __construct(private string $name, private string $program, private int $year, private string $email) {}
    public function save(): StudentProfileMemento { return new StudentProfileMemento([$this->name, $this->program, $this->year, $this->email]); }
    public function restore(StudentProfileMemento $memento): void { [$this->name, $this->program, $this->year, $this->email] = $memento->getState(); }
    public function change(string $program, int $year): void { $this->program = $program; $this->year = $year; }
    public function show(): void { echo "Name: $this->name | Program: $this->program | Year: $this->year | Email: $this->email\n"; }
}
class ProfileHistory {
    private array $history = [];
    public function push(StudentProfileMemento $memento): void { $this->history[] = $memento; }
    public function undo(StudentProfile $profile): void {
        $previous = array_pop($this->history);
        if ($previous) $profile->restore($previous);
    }
}
$profile = new StudentProfile('Juan Dela Cruz', 'BSIT', 3, 'juan@example.com');
$history = new ProfileHistory();
echo "Original Profile:\n"; $profile->show();
$history->push($profile->save());
$profile->change('BSCS', 4);
echo "Current Profile:\n"; $profile->show();
echo "Undo...\n"; $history->undo($profile);
echo "Restored Profile:\n"; $profile->show();
