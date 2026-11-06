<?php
interface Visitor {
    public function visitStudent(Student $record): void;
    public function visitFaculty(Faculty $record): void;
    public function visitAlumni(Alumni $record): void;
}
interface Element { public function accept(Visitor $visitor): void; public function getName(): string; }
class Student implements Element {
    public function __construct(private string $name) {}
    public function getName(): string { return $this->name; }
    public function accept(Visitor $visitor): void { $visitor->visitStudent($this); }
}
class Faculty implements Element {
    public function __construct(private string $name) {}
    public function getName(): string { return $this->name; }
    public function accept(Visitor $visitor): void { $visitor->visitFaculty($this); }
}
class Alumni implements Element {
    public function __construct(private string $name) {}
    public function getName(): string { return $this->name; }
    public function accept(Visitor $visitor): void { $visitor->visitAlumni($this); }
}
class CSVExportVisitor implements Visitor {
    public function visitStudent(Student $record): void { echo "Student exported: {$record->getName()}\n"; }
    public function visitFaculty(Faculty $record): void { echo "Faculty exported: {$record->getName()}\n"; }
    public function visitAlumni(Alumni $record): void { echo "Alumni exported: {$record->getName()}\n"; }
}
class ReportVisitor implements Visitor {
    public function visitStudent(Student $record): void { echo "Student report: {$record->getName()}\n"; }
    public function visitFaculty(Faculty $record): void { echo "Faculty report: {$record->getName()}\n"; }
    public function visitAlumni(Alumni $record): void { echo "Alumni report: {$record->getName()}\n"; }
}
class StatisticsVisitor implements Visitor {
    private int $count = 0;
    public function visitStudent(Student $record): void { $this->count++; }
    public function visitFaculty(Faculty $record): void { $this->count++; }
    public function visitAlumni(Alumni $record): void { $this->count++; }
    public function total(): int { return $this->count; }
}
// This challenge visitor demonstrates extension without editing record classes.
// It prints a PDF-ready report description; it does not generate a PDF file.
class PDFReportVisitor implements Visitor {
    public function visitStudent(Student $record): void { echo "PDF report entry: Student {$record->getName()}\n"; }
    public function visitFaculty(Faculty $record): void { echo "PDF report entry: Faculty {$record->getName()}\n"; }
    public function visitAlumni(Alumni $record): void { echo "PDF report entry: Alumni {$record->getName()}\n"; }
}
$records = [new Student('Juan'), new Faculty('Maria'), new Alumni('Pedro')];
foreach ([new CSVExportVisitor(), new ReportVisitor(), new PDFReportVisitor()] as $visitor) {
    echo get_class($visitor) . "\n";
    foreach ($records as $record) $record->accept($visitor);
}
$stats = new StatisticsVisitor();
foreach ($records as $record) $record->accept($stats);
echo 'Statistics total records: ' . $stats->total() . "\n";
