<?php

namespace Guava\Mailcheap\Accounts;

enum PermissionLevel: string
{
    case MASTER_ADMIN = 'MasterAdmin';
    case DOMAIN_ADMIN = 'DomainAdmin';
    case MAIL_USER = 'MailUser';
}
