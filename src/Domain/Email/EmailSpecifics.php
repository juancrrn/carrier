<?php

namespace Juancrrn\Lyra\Domain\Email;

use Carrier\Domain\Email\EmailUtils;
use Juancrrn\Lyra\Common\App;
use Juancrrn\Lyra\Common\TemplateUtils;
use Juancrrn\Lyra\Common\ValidationUtils;
use Juancrrn\Lyra\Common\View\Auth\PasswordResetProcessView;
use Juancrrn\Lyra\Domain\User\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * Utilidades de correo electrónico
 *
 * @package lyra
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class EmailSpecifics
{

	/**
	 * Envía un mensaje con información sobre privacidad y protección de datos.
	 * 
	 * @param User $user
	 * 
	 * @return bool
	 */
	public static function sendUserPrivacyMessage(User $user): bool
	{
		return EmailUtils::sendGenericMessage(
			$user,
			'Información sobre privacidad',
			'auth/email_privacy',
			array()
		);
	}

	/**
	 * Envía un mensaje de activación.
	 * 
	 * @param User $user
	 * 
	 * @return bool
	 */
	public static function sendUserActivationMessage(User $user): bool
	{
		return self::sendGenericMessage(
			$user,
			'Activar usuario',
			'auth/email_activation',
			array(
				'activation-url' => App::getSingleton()->getUrl() . PasswordResetProcessView::VIEW_ROUTE_BASIC . $user->getToken()
			)
		);
	}

	/**
	 * Envía un mensaje de aviso de activación correcta.
	 * 
	 * @param User $user
	 * 
	 * @return bool
	 */
	public static function sendUserActivatedMessage(User $user): bool
	{
		return self::sendGenericMessage(
			$user,
			'Usuario activado correctamente',
			'auth/email_activated',
			array()
		);
	}

	/**
	 * Envía un mensaje de restablecimiento de contraseña para un usuario
	 * 
	 * @param User $user
	 * 
	 * @return bool
	 */
	public static function sendUserPasswordResetMessage(User $user): bool
	{
		return self::sendGenericMessage(
			$user,
			'Restablecer contraseña',
			'auth/email_password_reset',
			array(
				'reset-url' => App::getSingleton()->getUrl() . PasswordResetProcessView::VIEW_ROUTE_BASIC . $user->getToken()
			)
		);
	}
}