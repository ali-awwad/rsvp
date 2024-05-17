import React from 'react'
import { PaperAirplaneIcon, ArrowPathIcon } from '@heroicons/react/24/outline'
import SuccessModal from '@/Shared/SuccessModal'
import { useForm, usePage } from '@inertiajs/react';
import Tabs from '@/Shared/Tabs'

export default function Form({campaign}) {
    const { flash, country_codes, replies, email } = usePage().props;
    const defaultCountryCode = country_codes.find(country_code => country_code.defaultSelected)?.code;
    const { data, setData, post, processing, errors } = useForm({
        email: email, // get email from props passed from the controller
        first_name: '',
        last_name: '',
        mobile: '',
        country_code: defaultCountryCode,
        company: '',
        reply: replies[0].value,
        notes: '',
    });


    function handleSubmit(event) {
        event.preventDefault();
        post(`/campaigns/${campaign.uuid}`);
    }

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value;
        setData(key, value);
    }
    return (
        <>
            <Tabs replies={replies} setData={setData} data={data} />
            <div className="mt-6">
                <form onSubmit={handleSubmit} method="POST" className="space-y-3">
                    <div>
                        <label htmlFor="first_name" className="sr-only">
                            First Name
                        </label>
                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            onChange={handleChange}
                            autoComplete="given-name"
                            placeholder="First Name"
                            defaultValue={data.first_name}
                            className="form-input"
                            disabled={processing}
                        />
                        {errors.first_name && <p className='text-red-500 text-sm'>{errors.first_name}</p>}
                    </div>
                    <div>
                        <label htmlFor="last_name" className="sr-only">
                            Family Name
                        </label>
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            onChange={handleChange}
                            autoComplete="family-name"
                            placeholder="Family Name"
                            defaultValue={data.last_name}
                            className="form-input"
                            disabled={processing}
                        />
                        {errors.last_name && <p className='text-red-500 text-sm'>{errors.last_name}</p>}
                    </div>

                    <div>
                        <label htmlFor="email" className="sr-only">
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            onChange={handleChange}
                            autoComplete="email"
                            placeholder="Email Address"
                            // required
                            defaultValue={data.email}
                            className="form-input"
                            disabled={processing}
                        />
                        {errors.email && <p className='text-red-500 text-sm'>{errors.email}</p>}
                    </div>
                    <div className='grid grid-cols-6 gap-4'>
                        <div className="col-span-2">
                            <label htmlFor="country_code" className="sr-only">
                                Country code
                            </label>
                            <select
                                name="country_code"
                                id="country_code"
                                onChange={handleChange}
                                autoComplete="country-code"
                                placeholder="Country code"
                                // required
                                className="form-input"
                                defaultValue={country_codes.find(country_code => country_code.defaultSelected)?.code}
                                disabled={processing}
                            >
                                {country_codes.map((country_code, index) => (
                                    <option key={index} value={country_code.code}>
                                        {country_code.name} ({country_code.code})
                                    </option>
                                ))}
                            </select>
                            {errors.country_code && <p className='text-red-500 text-sm'>{errors.country_code}</p>}
                        </div>
                        <div className="col-span-4">
                            <label htmlFor="mobile" className="sr-only">
                                Mobile number
                            </label>
                            <input
                                type="text"
                                name="mobile"
                                id="mobile"
                                onChange={handleChange}
                                autoComplete="tel"
                                placeholder="Mobile number"
                                // required
                                defaultValue={data.mobile}
                                className="form-input"
                                disabled={processing}
                            />
                            {errors.mobile && <p className='text-red-500 text-sm'>{errors.mobile}</p>}
                        </div>
                    </div>

                    <div>
                        <label htmlFor="company" className="sr-only">
                            Company
                        </label>
                        <input
                            type="text"
                            name="company"
                            id="company"
                            onChange={handleChange}
                            autoComplete="company"
                            placeholder="Company"
                            defaultValue={data.company}
                            className="form-input"
                            disabled={processing}
                        />
                        {errors.company && <p className='text-red-500 text-sm'>{errors.company}</p>}
                    </div>

                    <div>
                        <label htmlFor="notes" className="sr-only">
                            Notes
                        </label>
                        <textarea
                            name="notes"
                            id="notes"
                            onChange={handleChange}
                            placeholder="Notes"
                            className="form-input"
                            disabled={processing}
                        />
                        {errors.notes && <p className='text-red-500 text-sm'>{errors.notes}</p>}
                    </div>

                    <div>
                        <button
                            type="submit"
                            disabled={processing}
                            className="btn btn-primary "
                        >
                            {processing && <ArrowPathIcon className='animate-spin w-4 h-4 mr-1' />}
                            {!processing && <PaperAirplaneIcon className='w-4 h-4 mr-1' />}
                            Submit
                        </button>
                    </div>
                    {flash.error &&
                        <p className='text-red-500 bg-red-50 border-red-200 p-4 my-4'>
                            {flash.error}
                        </p>
                    }
                    {flash.success &&
                        <SuccessModal message={flash.success} />
                    }
                </form>
            </div>
        </>
    )
}
