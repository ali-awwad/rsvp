import React from 'react'
import { CalendarIcon, ClockIcon, MapPinIcon } from '@heroicons/react/24/outline'
import ParkingIcon from '@/Shared/ParkingIcon'

export default function CampaignInfo({ campaign }) {
    return (
        <div className="px-4 sm:px-6 sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left lg:flex lg:items-center">
            <div>
                {campaign.logo &&
                    <img src={campaign.logo} className='w-36' alt={`${campaign.title} Logo`} />
                }
                <h1 className="mt-4 text-2xl lg:text-3xl xl:text-4xl tracking-tight font-extrabold text-rsvp-darkblue sm:mt-5 sm:leading-none lg:mt-6">
                    <span className="md:block">{campaign.title}</span>
                </h1>
                {campaign.description &&
                    <p className="mt-3 text-base text-gray-700 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                        {campaign.description}
                    </p>
                }
                <div className='mt-4 text-rsvp-purple font-bold'>
                    {campaign.location &&
                        <div className="flex items-center space-x-2 text-base lg:text-base">
                            <MapPinIcon className='inline w-6 h-6 lg:w-10 lg:h-10' />
                            <span>{campaign.location}</span>
                        </div>
                    }
                    <div className="mt-4 flex items-center space-x-2 text-base lg:text-base">
                        <CalendarIcon className='inline w-6 h-6 lg:w-10 lg:h-10' />
                        <span>{campaign.start_date}</span>
                    </div>
                    <div className="mt-4 flex items-center space-x-2 text-base lg:text-base">
                        <ClockIcon className='inline w-6 h-6 lg:w-10 lg:h-10' />
                        <span>{campaign.start_time}</span>
                    </div>
                    {campaign.parking_link &&
                        <a href={campaign.parking_link} className='mt-4 flex items-center space-x-2 text-rsvp-darkblue text-base lg:text-base hover:underline'>
                            <ParkingIcon className='inline w-6 h-6 lg:w-8 lg:h-8 fill-current' />
                            <span>{campaign.parking}</span>
                        </a>
                    }
                </div>
                {campaign.sponsors.length > 0 &&
                    <div className='mt-10'>
                        <div className='grid grid-cols-2 md:grid-cols-4 gap-4 mt-4'>
                            {campaign.sponsors.map((sponsor, index) => (
                                <div key={index} className='flex items-center'>
                                    <img src={sponsor} className='w-20' alt={`Sponsor Logo`} />
                                </div>
                            ))}
                        </div>
                    </div>
                }
            </div>
        </div>
    )
}
