<?php
declare(strict_types=1);


namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ContactRequest
 * @package App\DTO
 */
class ContactRequest
{

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="Имя не может быть пустым"
     * )
     */
    private $name;


    /**
     * @var string
     *
     * @Assert\Email(
     *     message="Формат Email неверный"
     * )
     * @Assert\NotBlank(
     *     message="Email не может быть пустым"
     * )
     */
    private $email;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern = "/^\+\d{6,}/",
     *     message="Телефон должен быть в формате +30.."
     * )
     * @Assert\NotBlank(
     *     message="Телефон не может быть пустым"
     * )
     */
    private $phone;

    /**
     * @var string
     * @Assert\NotBlank(message="Тема не может быть пустой")
     */
    private $subject;

    /**
     * @var string
     * @Assert\NotBlank(message="Текст обращения не может быть пустым")
     */
    private $message;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }


}