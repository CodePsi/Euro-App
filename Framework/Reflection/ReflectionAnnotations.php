<?php


namespace Euro\Framework\Reflection;



class ReflectionAnnotations
{
    /**
     * @var \ReflectionClass
    */
    private $class;
    private $annotations = [];

    public function __construct(string $class)
    {
        $this->class = ReflectionClassWrapper::initiateClass($class);
    }

    public function getAllAnnotations() {
        if (count($this->annotations) === 0) return $this->annotations;
        else {
            $classAnnotations = $this->getAnnotationsFromComments($this->class->getDocComment());

            $this->annotations = array_push(new Annotation());
        }
    }

    private function getAnnotationsFromComments(string $comment) {
        preg_match_all("/(?:@[a-zA-Z][\d|\w]*(?:\(.*\))?)/", $comment, $out, PREG_PATTERN_ORDER);
        return $out;
    }

    private function createFoundAnnotations(array $annotations, object $target) {
        
    }

    private function getAnnotationArguments(string $annotation) {

    }

    private function getFieldsAnnotations() {
        $fields = $this->class->getProperties();
        foreach ($fields as $field) {
//            $field->
        }
    }
}