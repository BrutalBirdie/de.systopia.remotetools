<?php
/*
 * Copyright (C) 2023 SYSTOPIA GmbH
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation in version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types = 1);

namespace Civi\RemoteTools\Api4\Action;

use Civi\Api4\Generic\BasicGetFieldsAction;
use Civi\Api4\Generic\Result;
use Civi\RemoteTools\Api4\Action\Traits\ActionHandlerRunTrait;
use Civi\RemoteTools\Api4\Action\Traits\ProfileParameterOptionalTrait;
use Civi\RemoteTools\Api4\Action\Traits\RemoteContactIdParameterOptionalTrait;
use Civi\RemoteTools\Api4\Action\Traits\ResolvedContactIdTrait;

final class RemoteGetFieldsAction extends BasicGetFieldsAction implements ProfileAwareRemoteActionInterface {

  use ActionHandlerRunTrait;

  // Called by API explorer, so parameters need to be optional.
  use ProfileParameterOptionalTrait;

  use RemoteContactIdParameterOptionalTrait;

  use ResolvedContactIdTrait;

  /**
   * @todo: Filter information not relevant for remote API.
   */
  public function _run(Result $result): void {
    if (NULL === $this->profile) {
      $this->_ignoreMissingActionHandler = TRUE;
    }
    $this->doRun($result);
    $this->queryArray($result->getArrayCopy(), $result);
  }

}
