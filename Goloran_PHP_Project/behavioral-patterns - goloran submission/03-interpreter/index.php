<?php
class StudentContext {
    public function __construct(public string $program, public int $year) {}
}
interface Expression { public function interpret(StudentContext $student): bool; }
class TerminalExpression implements Expression {
    public function __construct(private string $field, private string|int $value) {}
    public function interpret(StudentContext $student): bool {
        return match ($this->field) {
            'PROGRAM' => $student->program === $this->value,
            'YEAR' => $student->year === $this->value,
            default => false
        };
    }
}
class AndExpression implements Expression {
    public function __construct(private Expression $left, private Expression $right) {}
    public function interpret(StudentContext $student): bool { return $this->left->interpret($student) && $this->right->interpret($student); }
}
class OrExpression implements Expression {
    public function __construct(private Expression $left, private Expression $right) {}
    public function interpret(StudentContext $student): bool { return $this->left->interpret($student) || $this->right->interpret($student); }
}
$student = new StudentContext('BSIT', 4);
$bsit = new TerminalExpression('PROGRAM', 'BSIT');
$year4 = new TerminalExpression('YEAR', 4);
$query = new AndExpression($bsit, $year4);
echo 'PROGRAM = "BSIT" AND YEAR = 4 => ' . ($query->interpret($student) ? 'TRUE' : 'FALSE') . "\n";
$either = new OrExpression($bsit, new TerminalExpression('PROGRAM', 'BSCS'));
echo 'PROGRAM = "BSIT" OR PROGRAM = "BSCS" => ' . ($either->interpret($student) ? 'TRUE' : 'FALSE') . "\n";
