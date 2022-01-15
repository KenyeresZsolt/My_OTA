<div class="card border-success mb-3 m-5">
    <div class="card-header">Kedvezmények szerkesztése</div>
    <div class="card-body">
        <form class="form-inline" action="/update-discounts/<?= $params['accm']['id'] ?>" method="POST">
            <div class="form-check" style="max-width: 15rem;">
                <label class="form-check-label" for="childrenDiscount">
                <input class="form-check-input" type="checkbox"  name="childrenDiscount" value="YES" <?= $params['accm']['children_discount'] === "YES" ? "checked" : "" ?>>
                    Gyermekkedvezmények
                </label>
            </div>
            <br>
            <div class="container">
                <table>
                    <tr>
                        <td>Mekkora kedvezményt biztosítasz?</td>
                        <td style="width: 50px;"></td>
                        <td style="width: 30rem;">Mire vonatkozik a kedvezmény?</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="form-control form-control-sm" type="text" name="childrenDiscountPercent" value="<?= $params['accm']['children_discount_percent'] ?>"/>
                                </div>
                                <label for="childrenDiscountPercent" class="col-sm-1 col-form-label">%</label>
                            </div>
                        </td>
                        <td style="width: 50px;"></td>
                        <td style="width: 35rem;">
                            <div class="container row">
                                <div class="form-check" style="max-width: 10rem;">
                                    <label class="form-check-label" for="childrenDiscountForAccm">
                                    <input class="form-check-input" type="checkbox"  name="childrenDiscountForAccm" value="YES" <?= $params['accm']['children_discount_for_accm'] === "YES" ? "checked" : "" ?>>
                                        szállás
                                    </label>
                                </div>
                                <?php if($params['accm']['meal_offered'] === "YES"): ?>
                                    <div class="form-check" style="max-width: 10rem;">
                                        <label class="form-check-label" for="childrenDiscountForMeals">
                                        <input class="form-check-input" type="checkbox"  name="childrenDiscountForMeals" value="YES" <?= $params['accm']['children_discount_for_meals'] === "YES" ? "checked" : "" ?>>
                                            étkezés
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <?php if($params['accm']['wellness_offered'] === "YES"): ?>
                                    <div class="form-check" style="max-width: 10rem;">
                                        <label class="form-check-label" for="childrenDiscountForWellness">
                                        <input class="form-check-input" type="checkbox"  name="childrenDiscountForWellness" value="YES" <?= $params['accm']['children_discount_for_wellness'] === "YES" ? "checked" : "" ?>>
                                            wellness
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="border: 1px dashed white">
            <div class="form-check" style="max-width: 15rem;">
                <label class="form-check-label" for="groupDiscount">
                <input class="form-check-input" type="checkbox"  name="groupDiscount" value="YES" <?= $params['accm']['group_discount'] === "YES" ? "checked" : "" ?>>
                    Csoportkedvezmény
                </label>
            </div>
            <br>
            <div class="container">
                <table>
                    <tr>
                        <td>Mekkora kedvezményt biztosítasz?</td>
                        <td style="width: 50px;"></td>
                        <td>Hány személy felett?</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="form-control form-control-sm" type="text" name="groupDiscountPercent" value="<?= $params['accm']['group_discount_percent'] ?>"/>
                                </div>
                                <label for="groupDiscountPercent" class="col-sm-1 col-form-label">%</label>
                            </div>
                        </td>
                        <td style="width: 50px;"></td>
                        <td>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="form-control form-control-sm" type="text" name="groupPersonNumber" value="<?= $params['accm']['group_person_number'] ?>"/>
                                </div>
                                <label for="groupPersonNumber" class="col-sm-2 col-form-label">fő</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="border: 1px dashed white">
            <div class="form-check" style="max-width: 15rem;">
                <label class="form-check-label" for="earlyBookingDiscount">
                <input class="form-check-input" type="checkbox"  name="earlyBookingDiscount" value="YES" <?= $params['accm']['early_booking_discount'] === "YES" ? "checked" : "" ?>>
                    Early Booking
                </label>
            </div>
            <br>
            <div class="container">
                <table>
                    <tr>
                        <td>Mekkora kedvezményt biztosítasz?</td>
                        <td style="width: 50px;"></td>
                        <td>Minimum hány nappal az érkezés előtt?</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="form-control form-control-sm" type="text" name="earlyBookingDiscountPercent" value="<?= $params['accm']['early_booking_discount_percent'] ?>"/>
                                </div>
                                <label for="earlyBookingDiscountPercent" class="col-sm-1 col-form-label">%</label>
                            </div>
                        </td>
                        <td style="width: 50px;"></td>
                        <td>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input class="form-control form-control-sm" type="text" name="earlyBookingDays" value="<?= $params['accm']['early_booking_days'] ?>"/>
                                </div>
                                <label for="earlyBookingDays" class="col-sm-3 col-form-label">nap</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="border: 1px dashed white">
            <div class="form-check" style="max-width: 15rem;">
                <label class="form-check-label" for="lastMinuteDiscount">
                <input class="form-check-input" type="checkbox"  name="lastMinuteDiscount" value="YES" <?= @$params['accm']['last_minute_discount'] === "YES" ? "checked" : "" ?>>
                    Last Minute kedvezmény
                </label>
            </div>
            <br>
            <div class="container">
                <table>
                    <tr>
                        <td>Mekkora kedvezményt biztosítasz?</td>
                        <td style="width: 50px;"></td>
                        <td>Maximum hány nappal az érkezés előtt?</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="form-control form-control-sm" type="text" name="lastMinuteDiscountPercent" value="<?= $params['accm']['last_minute_discount_percent'] ?>"/>
                                </div>
                                <label for="lastMinuteDiscountPercent" class="col-sm-1 col-form-label">%</label>
                            </div>
                        </td>
                        <td style="width: 50px;"></td>
                        <td>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input class="form-control form-control-sm" type="text" name="lastMinuteDays" value="<?= $params['accm']['last_minute_days'] ?>"/>
                                </div>
                                <label for="lastMinuteDays" class="col-sm-3 col-form-label">nap</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="border: 1px dashed white">
            <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
        </form>
    </div>
</div>