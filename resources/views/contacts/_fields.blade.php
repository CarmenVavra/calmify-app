{{-- Shared fields for creating and editing a trusted person. --}}
<x-form.input name="name"
              label="Name"
              :value="$contact?->name"
              autocomplete="off"
              maxlength="60"
              required
              hint="Ein Vorname oder Spitzname reicht." />

<x-form.input name="relation"
              label="Beziehung (optional)"
              :value="$contact?->relation"
              autocomplete="off"
              maxlength="60"
              placeholder="z. B. Schwester, Therapeutin" />

<x-form.input name="phone_number"
              label="Telefonnummer"
              type="tel"
              inputmode="tel"
              :value="$contact?->phone_number"
              autocomplete="off"
              maxlength="30"
              required
              placeholder="+49 170 1234567" />
