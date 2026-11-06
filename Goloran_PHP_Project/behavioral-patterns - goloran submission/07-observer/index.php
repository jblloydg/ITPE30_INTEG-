<?php
interface Observer { public function update(float $grade): void; }
interface Subject { public function attach(Observer $observer): void; public function notify(): void; }
class GradeSystem implements Subject {
    private array $observers = []; private float $grade = 0;
    public function attach(Observer $observer): void { $this->observers[] = $observer; }
    public function setGrade(float $grade): void { $this->grade = $grade; echo "Grade updated: $grade\n"; $this->notify(); }
    public function notify(): void { foreach ($this->observers as $observer) $observer->update($this->grade); }
}
class StudentPortal implements Observer { public function update(float $grade): void { echo "Student Portal: New grade posted ($grade).\n"; } }
class EmailNotification implements Observer { public function update(float $grade): void { echo "Email Notification: Your grade has been updated.\n"; } }
class ParentNotification implements Observer { public function update(float $grade): void { echo "Parent Notification: Student grade has been posted.\n"; } }
class AdviserNotification implements Observer { public function update(float $grade): void { echo "Adviser Notification: Grade update received.\n"; } }
$grades = new GradeSystem();
foreach ([new StudentPortal(), new EmailNotification(), new ParentNotification(), new AdviserNotification()] as $observer) $grades->attach($observer);
$grades->setGrade(1.75);
