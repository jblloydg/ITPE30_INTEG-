<?php
class Student {
    public function __construct(private string $id, private string $name) {}
    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
}
class StudentCollection implements IteratorAggregate {
    private array $students = [];
    public function add(Student $student): void { $this->students[] = $student; }
    public function getIterator(): Traversable { return new ArrayIterator($this->students); }
}
$students = new StudentCollection();
$students->add(new Student('2026-001', 'Juan'));
$students->add(new Student('2026-002', 'Maria'));
$students->add(new Student('2026-003', 'Pedro'));
echo "Student List\n";
foreach ($students as $student) echo $student->getId() . ' - ' . $student->getName() . "\n";
